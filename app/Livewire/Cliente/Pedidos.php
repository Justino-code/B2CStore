<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Produto;
use App\Models\Carrinho;
use App\Models\CarrinhoItem;

class Pedidos extends Component
{
    use WithPagination;

    // Filtros e busca
    public $statusFiltro = '';
    public $busca = '';
    public $dataInicio = '';
    public $dataFim = '';
    
    // Detalhes do pedido
    public $pedidoSelecionado = null;
    public $mostrarDetalhes = false;
    public $mostrarModalRepetir = false;
    public $pedidoParaRepetir = null;
    
    // Ordenação
    public $ordenarPor = 'created_at';
    public $ordenarDirecao = 'desc';

    // Paginação
    public $porPagina = 10;

    public function mount()
    {
        // Definir datas padrão (últimos 30 dias)
        $this->dataInicio = now()->subDays(30)->format('Y-m-d');
        $this->dataFim = now()->format('Y-m-d');
    }

    public function aplicarFiltros()
    {
        $this->resetPage();
    }

    public function limparFiltros()
    {
        $this->statusFiltro = '';
        $this->busca = '';
        $this->dataInicio = now()->subDays(30)->format('Y-m-d');
        $this->dataFim = now()->format('Y-m-d');
        $this->ordenarPor = 'created_at';
        $this->ordenarDirecao = 'desc';
        $this->resetPage();
    }

    public function ordenar($campo)
    {
        if ($this->ordenarPor === $campo) {
            $this->ordenarDirecao = $this->ordenarDirecao === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarPor = $campo;
            $this->ordenarDirecao = 'asc';
        }
    }

    public function verDetalhes($pedidoId)
    {
        $this->pedidoSelecionado = Pedido::with(['itens.produto.imagens', 'pagamento'])
            ->where('id_usuario', Auth::id())
            ->where('id_pedido', $pedidoId)
            ->first();

        if ($this->pedidoSelecionado) {
            $this->mostrarDetalhes = true;
        }
    }

    public function fecharDetalhes()
    {
        $this->mostrarDetalhes = false;
        $this->pedidoSelecionado = null;
    }

    public function confirmarRepetirPedido($pedidoId)
    {
        $this->pedidoParaRepetir = Pedido::with('itens.produto')
            ->where('id_usuario', Auth::id())
            ->where('id_pedido', $pedidoId)
            ->first();

        if ($this->pedidoParaRepetir) {
            $this->mostrarModalRepetir = true;
        }
    }

    public function repetirPedido()
    {
        if (!$this->pedidoParaRepetir) {
            return;
        }

        try {
            // Buscar ou criar carrinho
            $carrinho = Carrinho::firstOrCreate(
                ['id_usuario' => Auth::id()],
                ['created_at' => now()]
            );

            $produtosAdicionados = 0;
            $produtosIndisponiveis = [];

            foreach ($this->pedidoParaRepetir->itens as $item) {
                $produto = Produto::find($item->id_produto);
                
                if (!$produto || !$produto->ativo || $produto->estoque <= 0) {
                    $produtosIndisponiveis[] = $item->produto->nome;
                    continue;
                }

                // Verificar se já está no carrinho
                $itemExistente = CarrinhoItem::where('id_carrinho', $carrinho->id_carrinho)
                    ->where('id_produto', $produto->id_produto)
                    ->first();

                if ($itemExistente) {
                    // Incrementar quantidade se não ultrapassar estoque
                    $novaQuantidade = $itemExistente->quantidade + $item->quantidade;
                    if ($novaQuantidade <= $produto->estoque) {
                        $itemExistente->quantidade = $novaQuantidade;
                        $itemExistente->save();
                        $produtosAdicionados++;
                    } else {
                        $produtosIndisponiveis[] = $produto->nome;
                    }
                } else {
                    // Adicionar novo item
                    CarrinhoItem::create([
                        'id_carrinho' => $carrinho->id_carrinho,
                        'id_produto' => $produto->id_produto,
                        'quantidade' => $item->quantidade,
                        'preco_unitario' => $produto->preco_promocional ?? $produto->preco,
                        'created_at' => now()
                    ]);
                    $produtosAdicionados++;
                }
            }

            // Fechar modal
            $this->mostrarModalRepetir = false;
            $this->pedidoParaRepetir = null;

            // Disparar evento para atualizar carrinho
            $this->dispatch('carrinho-atualizado');

            // Mostrar mensagem
            $mensagem = $produtosAdicionados . ' produto(s) adicionado(s) ao carrinho!';
            
            if (!empty($produtosIndisponiveis)) {
                $mensagem .= ' Os seguintes produtos não estão disponíveis: ' . implode(', ', $produtosIndisponiveis);
            }

            $this->dispatch('notificar', [
                'tipo' => $produtosAdicionados > 0 ? 'sucesso' : 'info',
                'mensagem' => $mensagem
            ]);

            if ($produtosAdicionados > 0) {
                // Redirecionar para o carrinho
                return redirect()->route('cliente.carrinho');
            }

        } catch (\Exception $e) {
            $this->dispatch('notificar', [
                'tipo' => 'erro',
                'mensagem' => 'Erro ao repetir pedido: ' . $e->getMessage()
            ]);
        }
    }

    public function baixarNotaFiscal($pedidoId)
    {
        $pedido = Pedido::where('id_usuario', Auth::id())
            ->where('id_pedido', $pedidoId)
            ->first();

        if ($pedido) {
            // Aqui implementaria o download da nota fiscal
            $this->dispatch('notificar', [
                'tipo' => 'info',
                'mensagem' => 'Funcionalidade de download de nota fiscal em desenvolvimento.'
            ]);
        }
    }

    public function cancelarPedido($pedidoId)
    {
        $pedido = Pedido::where('id_usuario', Auth::id())
            ->where('id_pedido', $pedidoId)
            ->first();

        if ($pedido && $pedido->status === 'pendente') {
            $pedido->status = 'cancelado';
            $pedido->save();

            $this->dispatch('notificar', [
                'tipo' => 'sucesso',
                'mensagem' => 'Pedido cancelado com sucesso!'
            ]);
        } else {
            $this->dispatch('notificar', [
                'tipo' => 'erro',
                'mensagem' => 'Este pedido não pode ser cancelado.'
            ]);
        }
    }

    public function getPedidosQuery()
    {
        $query = Pedido::where('id_usuario', Auth::id());

        // Aplicar filtros
        if ($this->statusFiltro) {
            $query->where('status', $this->statusFiltro);
        }

        if ($this->busca) {
            $query->where(function($q) {
                $q->where('codigo_pedido', 'like', '%' . $this->busca . '%')
                  ->orWhereHas('itens.produto', function($q) {
                      $q->where('nome', 'like', '%' . $this->busca . '%');
                  });
            });
        }

        if ($this->dataInicio) {
            $query->whereDate('created_at', '>=', $this->dataInicio);
        }

        if ($this->dataFim) {
            $query->whereDate('created_at', '<=', $this->dataFim);
        }

        // Ordenação
        $query->orderBy($this->ordenarPor, $this->ordenarDirecao);

        return $query;
    }

    public function getPedidosProperty()
    {
        return $this->getPedidosQuery()->paginate($this->porPagina);
    }

    public function getEstatisticasProperty()
    {
        return [
            'total' => Pedido::where('id_usuario', Auth::id())->count(),
            'entregues' => Pedido::where('id_usuario', Auth::id())->where('status', 'entregue')->count(),
            'pendentes' => Pedido::where('id_usuario', Auth::id())->where('status', 'pendente')->count(),
            'processando' => Pedido::where('id_usuario', Auth::id())->where('status', 'processando')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.cliente.pedidos', [
            'pedidos' => $this->pedidos,
            'estatisticas' => $this->estatisticas,
        ])->layout('components.layouts.cliente', [
            'titulo' => 'Meus Pedidos - B2CStore'
        ]);
    }
}