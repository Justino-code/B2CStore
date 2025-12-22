<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $stats = [];
    public $pedidosRecentes = [];
    public $produtosMaisVendidos = [];
    public $dadosGrafico = [];
    public $periodoSelecionado = '30';

    public function mount()
    {
        $this->carregarEstatisticas();
        $this->carregarPedidosRecentes();
        $this->carregarProdutosMaisVendidos();
        $this->carregarDadosGrafico();
    }

    protected function carregarEstatisticas()
    {
        // Vendas totais (últimos 30 dias) - pedidos entregues
        $vendasTotais = Pedido::where('status', 'entregue')
            ->where('created_at', '>=', now()->subDays(30))
            ->sum('total');

        // Total de pedidos (últimos 30 dias)
        $totalPedidos = Pedido::where('created_at', '>=', now()->subDays(30))
            ->count();

        // Total de clientes
        $totalClientes = Usuario::where('role', 'cliente')->count();

        // Total de produtos ativos
        $totalProdutos = Produto::where('ativo', true)->count();

        // Cálculo de crescimento (comparação com período anterior)
        $vendasAnteriores = Pedido::where('status', 'entregue')
            ->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])
            ->sum('total');

        $pedidosAnteriores = Pedido::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])
            ->count();

        $crescimentoVendas = $vendasAnteriores > 0
            ? round((($vendasTotais - $vendasAnteriores) / $vendasAnteriores) * 100, 1)
            : 0;

        $crescimentoPedidos = $pedidosAnteriores > 0
            ? round((($totalPedidos - $pedidosAnteriores) / $pedidosAnteriores) * 100, 1)
            : 0;

        $this->stats = [
            'vendas_totais' => [
                'valor' => 'R$ ' . number_format($vendasTotais, 2, ',', '.'),
                'variacao' => $crescimentoVendas > 0 ? '+' . $crescimentoVendas . '%' : $crescimentoVendas . '%',
                'tendencia' => $crescimentoVendas > 0 ? 'up' : ($crescimentoVendas < 0 ? 'down' : 'neutral'),
            ],
            'total_pedidos' => [
                'valor' => $totalPedidos,
                'variacao' => $crescimentoPedidos > 0 ? '+' . $crescimentoPedidos . '%' : $crescimentoPedidos . '%',
                'tendencia' => $crescimentoPedidos > 0 ? 'up' : ($crescimentoPedidos < 0 ? 'down' : 'neutral'),
            ],
            'total_clientes' => [
                'valor' => $totalClientes,
                'variacao' => '+5.3%', // Mock por enquanto
                'tendencia' => 'up',
            ],
            'total_produtos' => [
                'valor' => $totalProdutos,
                'variacao' => '+2.1%', // Mock por enquanto
                'tendencia' => 'up',
            ],
        ];
    }

    protected function carregarPedidosRecentes()
    {
        $this->pedidosRecentes = Pedido::with('usuario')
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($pedido) {
                return [
                    'id_pedido' => $pedido->id_pedido,
                    'codigo_pedido' => $pedido->codigo_pedido,
                    'nome_cliente' => $pedido->usuario?->nome ?? 'Cliente Externo',
                    'email_cliente' => $pedido->usuario?->email ?? '-',
                    'data' => $pedido->created_at->format('d/m/Y'),
                    'hora' => $pedido->created_at->format('H:i'),
                    'total' => 'R$ ' . number_format($pedido->total, 2, ',', '.'),
                    'status' => $pedido->status,
                    'cor_status' => $this->obterCorStatus($pedido->status),
                ];
            })
            ->toArray();
    }

    protected function carregarProdutosMaisVendidos()
    {
        // Primeiro, obtenha os IDs dos produtos mais vendidos
        $produtosMaisVendidosIds = DB::table('pedido_itens')
            ->select(
                'pedido_itens.id_produto',
                DB::raw('SUM(pedido_itens.quantidade) as total_vendido'),
                DB::raw('SUM(pedido_itens.quantidade * pedido_itens.preco_unitario) as receita_total')
            )
            ->join('pedidos', 'pedido_itens.id_pedido', '=', 'pedidos.id_pedido')
            ->where('pedidos.status', 'entregue')
            ->groupBy('pedido_itens.id_produto')
            ->orderBy('total_vendido', 'desc')
            ->limit(5)
            ->get();

        // Prepare os dados para retorno
        $this->produtosMaisVendidos = [];

        foreach ($produtosMaisVendidosIds as $indice => $item) {
            $produto = Produto::with(['imagens'])->find($item->id_produto);

            if ($produto) {
                $this->produtosMaisVendidos[] = [
                    'posicao' => $indice + 1,
                    'id_produto' => $produto->id_produto,
                    'nome' => $produto->nome,
                    'imagem' => $produto->imagens->first()?->url_imagem ?? '/images/placeholder.png',
                    'total_vendido' => $item->total_vendido,
                    'receita_total' => 'R$ ' . number_format($item->receita_total ?? 0, 2, ',', '.'),
                    'status' => $produto->ativo ? 'active' : 'inactive',
                ];
            }
        }

        // Se não houver produtos vendidos, retorne array vazio
        if (empty($this->produtosMaisVendidos)) {
            $this->produtosMaisVendidos = [];
        }
    }

    protected function carregarDadosGrafico()
    {
        $dias = (int) $this->periodoSelecionado;
        $dataInicio = now()->subDays($dias);

        $dados = Pedido::where('status', 'entregue')
            ->where('created_at', '>=', $dataInicio)
            ->select(
                DB::raw('DATE(created_at) as data'),
                DB::raw('COUNT(*) as pedidos'),
                DB::raw('SUM(total) as receita')
            )
            ->groupBy('data')
            ->orderBy('data')
            ->get();

        $labels = [];
        $dadosPedidos = [];
        $dadosReceita = [];

        for ($i = 0; $i <= $dias; $i++) {
            $data = $dataInicio->copy()->addDays($i)->format('Y-m-d');
            $labelDia = $dataInicio->copy()->addDays($i)->format('d/m');

            $dadosDia = $dados->firstWhere('data', $data);

            $labels[] = $labelDia;
            $dadosPedidos[] = $dadosDia ? $dadosDia->pedidos : 0;
            $dadosReceita[] = $dadosDia ? (float) $dadosDia->receita : 0;
        }

        $this->dadosGrafico = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pedidos',
                    'data' => $dadosPedidos,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => 'Receita (R$)',
                    'data' => $dadosReceita,
                    'borderColor' => '#8b5cf6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'fill' => true,
                ]
            ]
        ];
    }

    public function updatedPeriodoSelecionado()
    {
        $this->carregarDadosGrafico();
    }

    public function atualizarDados()
    {
        $this->carregarEstatisticas();
        $this->carregarPedidosRecentes();
        $this->carregarProdutosMaisVendidos();
        $this->carregarDadosGrafico();

        $this->dispatch('notificar', [
            'tipo' => 'success',
            'mensagem' => 'Dados atualizados com sucesso!'
        ]);
    }

    protected function obterCorStatus($status)
    {
        return match($status) {
            'pendente' => 'yellow',
            'pago' => 'blue',
            'processando' => 'blue',
            'enviado' => 'purple',
            'entregue' => 'green',
            'cancelado' => 'red',
            default => 'gray',
        };
    }

    protected function traduzirStatus($status)
    {
        return match($status) {
            'pending' => 'pendente',
            'pago' => 'pago',
            'processing' => 'processando',
            'enviado' => 'enviado',
            'completed' => 'entregue',
            'cancelled' => 'cancelado',
            default => $status,
        };
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('components.layouts.admin', [
                'pageTitle' => 'Dashboard',
                'pageDescription' => 'Visão geral do seu negócio'
            ]);
    }
}
