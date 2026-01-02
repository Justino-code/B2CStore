<?php

namespace App\Livewire\Admin\Relatorio;

use Livewire\Component;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Usuario as User;
use App\Models\Categoria;
use App\Models\Cupom;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

use App\Livewire\Admin\Relatorio\Traits\{
    RelatorioVendasTrait,
    RelatorioProdutosTrait,
    RelatorioClientesTrait,
    RelatorioCategoriasTrait,
    RelatorioCuponsTrait,
};

use App\Exports\{
    RelatorioVendasExport,
    RelatorioProdutosExport,
    RelatorioClientesExport,
    RelatorioCategoriasExport,
    RelatorioCuponsExport,
};

use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

#[Layout('components.layouts.admin')]
class Index extends Component
{
    use RelatorioVendasTrait;
    use RelatorioProdutosTrait;
    use RelatorioClientesTrait;
    use RelatorioCategoriasTrait;
    use RelatorioCuponsTrait;

    public $abaAtiva = 'vendas';
    public $periodo = '30dias';
    public $dataInicio;
    public $dataFim;
    public $formatoExportacao = 'pdf';
    
    // Filtros avançados
    public $categoriaId = '';
    public $produtoId = '';
    public $statusPedido = '';
    public $clienteId = '';
    public $metodoPagamento = '';
    
    // Filtros de ordenação
    public $ordenarPor = 'valor_total';
    public $direcaoOrdenacao = 'desc';
    
    // Dados dos relatórios
    public $dadosVendas = [];
    public $dadosProdutos = [];
    public $dadosClientes = [];
    public $dadosCategorias = [];
    public $dadosCupons = [];
    public $totalPedidos;
    
    // Estado do loading
    public $isLoading = false;

    public function mount()
    {
        $this->atualizarDatasPorPeriodo();
        $this->carregarDados();
    }

    public function updatedAbaAtiva()
    {
        $this->carregarDados();
    }

    public function updatedPeriodo()
    {
        $this->atualizarDatasPorPeriodo();
        $this->carregarDados();
    }

    public function updated($property)
    {
        if (in_array($property, ['dataInicio', 'dataFim', 'categoriaId', 'produtoId', 'statusPedido', 'clienteId', 'metodoPagamento'])) {
            $this->carregarDados();
        }
    }

    private function atualizarDatasPorPeriodo()
    {
        $now = Carbon::now();
        
        switch ($this->periodo) {
            case 'hoje':
                $this->dataInicio = $now->format('Y-m-d');
                $this->dataFim = $now->format('Y-m-d');
                break;
            case 'semana':
                $this->dataInicio = $now->copy()->startOfWeek()->format('Y-m-d');
                $this->dataFim = $now->copy()->endOfWeek()->format('Y-m-d');
                break;
            case 'mes':
                $this->dataInicio = $now->copy()->startOfMonth()->format('Y-m-d');
                $this->dataFim = $now->copy()->endOfMonth()->format('Y-m-d');
                break;
            case '30dias':
                $this->dataInicio = $now->copy()->subDays(30)->format('Y-m-d');
                $this->dataFim = $now->format('Y-m-d');
                break;
            case 'trimestre':
                $this->dataInicio = $now->copy()->startOfQuarter()->format('Y-m-d');
                $this->dataFim = $now->copy()->endOfQuarter()->format('Y-m-d');
                break;
            case 'ano':
                $this->dataInicio = $now->copy()->startOfYear()->format('Y-m-d');
                $this->dataFim = $now->copy()->endOfYear()->format('Y-m-d');
                break;
            case 'personalizado':
                // Mantém as datas atuais
                break;
        }
    }

    public function carregarDados()
    {
        $this->isLoading = true;
        
        try {
            $dataInicio = Carbon::parse($this->dataInicio)->startOfDay();
            $dataFim = Carbon::parse($this->dataFim)->endOfDay();

            switch ($this->abaAtiva) {
                case 'vendas':
                    $this->carregarRelatorioVendas($dataInicio, $dataFim);
                    break;
                case 'produtos':
                    $this->carregarRelatorioProdutos($dataInicio, $dataFim);
                    break;
                case 'clientes':
                    $this->carregarRelatorioClientes($dataInicio, $dataFim);
                    break;
                case 'categorias':
                    $this->carregarRelatorioCategorias($dataInicio, $dataFim);
                    break;
                case 'cupons':
                    $this->carregarRelatorioCupons($dataInicio, $dataFim);
                    break;
            }
        } catch (\Exception $e) {
            logger()->error('Erro ao carregar relatórios: ' . $e->getMessage());
            session()->flash('error', 'Erro ao carregar dados do relatório. Tente novamente.');
        } finally {
            $this->isLoading = false;
        }
    }

    public function exportarRelatorio()
    {
        try {
            $nomeArquivo = 'relatorio-' . $this->abaAtiva . '-' . date('Y-m-d-H-i');
            
            // Preparar dados comuns
            $periodo = [
                'inicio' => Carbon::parse($this->dataInicio)->format('d/m/Y'),
                'fim' => Carbon::parse($this->dataFim)->format('d/m/Y')
            ];
            
            switch ($this->formatoExportacao) {
                case 'excel':
                    return $this->exportarParaExcel($nomeArquivo, $periodo);
                    
                case 'pdf':
                    return $this->exportarParaPDF($nomeArquivo, $periodo);
                    
                case 'csv':
                    return $this->exportarParaCSV($nomeArquivo, $periodo);
                    
                default:
                    throw new \Exception('Formato de exportação não suportado');
            }

        } catch (\Exception $e) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Erro ao exportar relatório: ' . $e->getMessage()
            );
        }
    }

    private function exportarParaExcel($nomeArquivo, $periodo)
    {
        $dados = [];
        $exportClass = null;
        
        switch ($this->abaAtiva) {
            case 'vendas':
                $exportClass = new RelatorioVendasExport(
                    $this->dadosVendas, 
                    'Relatório de Vendas', 
                    $periodo
                );
                break;
            case 'produtos':
                $exportClass = new RelatorioProdutosExport(
                    $this->dadosProdutos, 
                    'Relatório de Produtos', 
                    $periodo
                );
                break;
            case 'clientes':
                $exportClass = new RelatorioClientesExport(
                    $this->dadosClientes, 
                    'Relatório de Clientes', 
                    $periodo
                );
                break;
            case 'categorias':
                $exportClass = new RelatorioCategoriasExport(
                    $this->dadosCategorias, 
                    'Relatório de Categorias', 
                    $periodo
                );
                break;
            case 'cupons':
                $exportClass = new RelatorioCuponsExport(
                    $this->dadosCupons, 
                    'Relatório de Cupons', 
                    $periodo
                );
                break;
        }
        
        if (!$exportClass) {
            throw new \Exception('Tipo de relatório não suportado para exportação');
        }
        
        return Excel::download($exportClass, $nomeArquivo . '.xlsx');
    }

    private function exportarParaPDF($nomeArquivo, $periodo)
    {
        $dados = $this->getDadosParaExportacao();
        
        if (empty($dados)) {
            throw new \Exception('Nenhum dado disponível para exportação');
        }
        
        $pdf = Pdf::loadView('exports.relatorio-pdf', [
            'titulo' => $this->getTituloRelatorio(),
            'periodo' => $periodo,
            'abaAtiva' => $this->abaAtiva,
            'dados' => $dados,
            'filtros' => $this->getFiltrosAtivos(),
            'dataGeracao' => now()->format('d/m/Y H:i:s')
        ]);
        
        $pdf->setPaper('A4', 'portrait');
        
        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            $nomeArquivo . '.pdf'
        );
    }

    private function exportarParaCSV($nomeArquivo, $periodo)
    {
        $dados = $this->getDadosParaExportacao();
        
        if (empty($dados)) {
            throw new \Exception('Nenhum dado disponível para exportação');
        }
        
        $csvContent = $this->gerarConteudoCSV($dados, $periodo);
        
        return response()->streamDownload(
            function () use ($csvContent) {
                echo $csvContent;
            },
            $nomeArquivo . '.csv',
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $nomeArquivo . '.csv"',
            ]
        );
    }

    private function getDadosParaExportacao()
    {
        switch ($this->abaAtiva) {
            case 'vendas':
                return $this->dadosVendas;
            case 'produtos':
                return $this->dadosProdutos;
            case 'clientes':
                return $this->dadosClientes;
            case 'categorias':
                return $this->dadosCategorias;
            case 'cupons':
                return $this->dadosCupons;
            default:
                return [];
        }
    }

private function gerarCSVCategorias($dados)
{
    $lines = [];
    
    if (!empty($dados['desempenhoCategorias'])) {
        $lines[] = 'DESEMPENHO POR CATEGORIA';
        $lines[] = 'Categoria;Status;Pedidos;Produtos Vendidos;Quantidade Total;Valor Total;Preço Médio';
        
        foreach ($dados['desempenhoCategorias'] as $categoria) {
            $lines[] = $categoria->nome . ';' . 
                      ($categoria->ativo ? 'Ativa' : 'Inativa') . ';' . 
                      $categoria->pedidos . ';' . $categoria->produtos_vendidos . ';' . 
                      $categoria->quantidade_total . ';' . $categoria->valor_total . ';' . 
                      $categoria->preco_medio;
        }
        $lines[] = '';
    }
    
    return $lines;
}

private function gerarCSVCupons($dados)
{
    $lines = [];
    
    $lines[] = 'ESTATÍSTICAS';
    $lines[] = 'Total de Pedidos;' . ($dados['estatisticas']['totalPedidos'] ?? 0);
    $lines[] = 'Pedidos com Cupom;' . ($dados['estatisticas']['pedidosComCupom'] ?? 0);
    $lines[] = 'Taxa de Utilização;' . number_format($dados['estatisticas']['taxaUtilizacao'] ?? 0, 1) . '%';
    $lines[] = 'Ticket Médio com Cupom;' . ($dados['estatisticas']['valorMedioComCupom'] ?? 0);
    $lines[] = 'Ticket Médio sem Cupom;' . ($dados['estatisticas']['valorMedioSemCupom'] ?? 0);
    
    $diferenca = ($dados['estatisticas']['valorMedioComCupom'] ?? 0) - ($dados['estatisticas']['valorMedioSemCupom'] ?? 0);
    $lines[] = 'Diferença;' . ($diferenca >= 0 ? '+' : '') . $diferenca;
    $lines[] = '';
    
    if (!empty($dados['cuponsMaisUsados'])) {
        $lines[] = 'CUPONS MAIS USADOS';
        $lines[] = 'Código;Tipo;Desconto;Usos;Total Descontado;Valor Total Vendas;Status';
        
        foreach ($dados['cuponsMaisUsados'] as $cupom) {
            $desconto = $cupom->tipo_desconto == 'percentual' ? 
                $cupom->valor_desconto . '%' : 
                $cupom->valor_desconto;
            
            $lines[] = $cupom->codigo . ';' . 
                      ($cupom->tipo_desconto == 'percentual' ? 'Percentual' : 'Fixo') . ';' . 
                      $desconto . ';' . $cupom->usos . ';' . $cupom->total_descontado . ';' . 
                      $cupom->valor_total_vendas . ';' . ($cupom->ativo ? 'Ativo' : 'Inativo');
        }
    }
    
    return $lines;
}

    private function getTituloRelatorio()
    {
        $titulos = [
            'vendas' => 'Relatório de Vendas',
            'produtos' => 'Relatório de Produtos',
            'clientes' => 'Relatório de Clientes',
            'categorias' => 'Relatório de Categorias',
            'cupons' => 'Relatório de Cupons',
        ];
        
        return $titulos[$this->abaAtiva] ?? 'Relatório';
    }

    private function getFiltrosAtivos()
    {
        $filtros = [];
        
        if ($this->categoriaId) {
            $categoria = Categoria::find($this->categoriaId);
            if ($categoria) {
                $filtros['Categoria'] = $categoria->nome;
            }
        }
        
        if ($this->produtoId) {
            $produto = Produto::find($this->produtoId);
            if ($produto) {
                $filtros['Produto'] = $produto->nome;
            }
        }
        
        if ($this->statusPedido) {
            $filtros['Status do Pedido'] = ucfirst($this->statusPedido);
        }
        
        if ($this->clienteId) {
            $cliente = User::find($this->clienteId);
            if ($cliente) {
                $filtros['Cliente'] = $cliente->nome;
            }
        }
        
        if ($this->metodoPagamento) {
            $filtros['Método de Pagamento'] = ucfirst($this->metodoPagamento);
        }
        
        return $filtros;
    }

    private function gerarConteudoCSV($dados, $periodo)
    {
        $lines = [];
        $titulo = $this->getTituloRelatorio();
        
        // Cabeçalho
        $lines[] = $titulo;
        $lines[] = 'Período: ' . $periodo['inicio'] . ' até ' . $periodo['fim'];
        $lines[] = 'Data de geração: ' . now()->format('d/m/Y H:i:s');
        $lines[] = '';
        
        // Dados específicos por tipo de relatório
        switch ($this->abaAtiva) {
            case 'vendas':
                $lines = array_merge($lines, $this->gerarCSVVendas($dados));
                break;
            case 'produtos':
                $lines = array_merge($lines, $this->gerarCSVProdutos($dados));
                break;
            case 'clientes':
                $lines = array_merge($lines, $this->gerarCSVClientes($dados));
                break;
            case 'categorias':
                $lines = array_merge($lines, $this->gerarCSVCategorias($dados));
                break;
            case 'cupons':
                $lines = array_merge($lines, $this->gerarCSVCupons($dados));
                break;
        }
        
        return implode(PHP_EOL, $lines);
    }

    private function gerarCSVVendas($dados)
    {
        $lines = [];
        
        $lines[] = 'TOTAIS';
        $lines[] = 'Total de Vendas;' . ($dados['totais']['vendas'] ?? 0);
        $lines[] = 'Total de Pedidos;' . ($dados['totais']['pedidos'] ?? 0);
        $lines[] = 'Pedidos Entregues;' . ($dados['totais']['entregues'] ?? 0);
        $lines[] = 'Ticket Médio;' . ($dados['totais']['ticketMedio'] ?? 0);
        $lines[] = '';
        
        if (!empty($dados['porStatus'])) {
            $lines[] = 'VENDAS POR STATUS';
            $lines[] = 'Status;Pedidos;Valor Total;Percentual';
            
            $totalPedidos = $dados['totais']['pedidos'] ?? 0;
            foreach ($dados['porStatus'] as $status => $detalhes) {
                $percentual = $totalPedidos > 0 ? ($detalhes['total'] / $totalPedidos * 100) : 0;
                $lines[] = ucfirst($status) . ';' . $detalhes['total'] . ';' . 
                          ($detalhes['valor'] ?? 0) . ';' . number_format($percentual, 1) . '%';
            }
            $lines[] = '';
        }
        
        return $lines;
    }

    private function gerarCSVProdutos($dados)
    {
        $lines = [];
        
        if (!empty($dados['produtosMaisVendidos'])) {
            $lines[] = 'PRODUTOS MAIS VENDIDOS';
            $lines[] = 'Produto;SKU;Quantidade Vendida;Valor Total;Preço Médio';
            
            foreach ($dados['produtosMaisVendidos'] as $produto) {
                $lines[] = $produto->nome . ';' . $produto->sku . ';' . 
                          $produto->quantidade_vendida . ';' . $produto->valor_total . ';' . 
                          $produto->preco_medio_vendido;
            }
            $lines[] = '';
        }
        
        return $lines;
    }

    private function gerarCSVClientes($dados)
    {
        $lines = [];
        
        $lines[] = 'TOTAIS';
        $lines[] = 'Total de Clientes;' . ($dados['totais']['totalClientes'] ?? 0);
        $lines[] = 'Novos Clientes;' . ($dados['totais']['novosClientes'] ?? 0);
        $lines[] = '';
        
        if (!empty($dados['clientesMaisAtivos'])) {
            $lines[] = 'CLIENTES MAIS ATIVOS';
            $lines[] = 'Cliente;Email;Pedidos;Valor Total;Ticket Médio;Última Compra';
            
            foreach ($dados['clientesMaisAtivos'] as $cliente) {
                $ticketMedio = $cliente->total_pedidos > 0 ? 
                    $cliente->valor_total / $cliente->total_pedidos : 0;
                
                $lines[] = $cliente->nome . ';' . $cliente->email . ';' . 
                          $cliente->total_pedidos . ';' . $cliente->valor_total . ';' . 
                          $ticketMedio . ';' . ($cliente->ultima_compra ?: 'N/A');
            }
        }
        
        return $lines;
    }

    public function limparFiltros()
    {
        $this->categoriaId = '';
        $this->produtoId = '';
        $this->statusPedido = '';
        $this->clienteId = '';
        $this->metodoPagamento = '';
        $this->ordenarPor = 'valor_total';
        $this->direcaoOrdenacao = 'desc';
        $this->carregarDados();
    }

    public function alternarOrdenacao($campo)
    {
        if ($this->ordenarPor === $campo) {
            $this->direcaoOrdenacao = $this->direcaoOrdenacao === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarPor = $campo;
            $this->direcaoOrdenacao = 'desc';
        }
        $this->carregarDados();
    }

    public function selecionarAba($aba)
    {
        $this->abaAtiva = $aba;
        $this->carregarDados();
    }

    #[Computed]
    public function categorias()
    {
        return Categoria::where('ativo', true)
            ->orderBy('nome')
            ->get(['id_categoria', 'nome']);
    }

    #[Computed]
    public function produtos()
    {
        return Produto::where('ativo', true)
            ->orderBy('nome')
            ->get(['id_produto', 'nome', 'sku']);
    }

    #[Computed]
    public function clientes()
    {
        return User::where('role', 'cliente')
            ->orderBy('nome')
            ->get(['id_usuario', 'nome', 'email']);
    }

    #[Computed]
    public function metodosPagamento()
    {
        return ['cartao' => 'Cartão', 'multicaixa' => 'Multicaixa', 'dinheiro' => 'Dinheiro'];
    }

    public function render()
    {
        return view('livewire.admin.relatorio.index');
    }
}