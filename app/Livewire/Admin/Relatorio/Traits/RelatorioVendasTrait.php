<?php

namespace App\Livewire\Admin\Relatorio\Traits;

use App\Models\Pedido;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait RelatorioVendasTrait
{
    private function carregarRelatorioVendas($dataInicio, $dataFim)
    {
        $query = Pedido::whereBetween('created_at', [$dataInicio, $dataFim]);

        // Aplicar filtros
        if ($this->statusPedido) {
            $query->where('status', $this->statusPedido);
        }
        
        if ($this->clienteId) {
            $query->where('id_usuario', $this->clienteId);
        }
        
        if ($this->categoriaId) {
            $query->whereHas('itens.produto', function ($q) {
                $q->where('id_categoria', $this->categoriaId);
            });
        }

        // Total de vendas (apenas pedidos entregues)
        $totalVendas = clone $query;
        $totalVendas = $totalVendas->where('status', 'entregue')->sum('total');

        // Número de pedidos
        $totalPedidos = clone $query;
        $totalPedidos = $totalPedidos->count();
        $this->totalPedidos = $totalPedidos;
        
        $pedidosEntregues = clone $query;
        $pedidosEntregues = $pedidosEntregues->where('status', 'entregue')->count();

        // Ticket médio
        $ticketMedio = $pedidosEntregues > 0 ? $totalVendas / $pedidosEntregues : 0;

        // Vendas por status
        $vendasPorStatus = clone $query;
        $vendasPorStatus = $vendasPorStatus
            ->select('status', DB::raw('COUNT(*) as total'), DB::raw('SUM(total) as valor'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => [
                    'total' => $item->total ?? 0,
                    'valor' => $item->valor ?? 0
                ]];
            })->toArray();

        // Vendas por dia (últimos 15 dias para gráfico)
        $vendasPorDia = Pedido::whereBetween('created_at', [$dataInicio, $dataFim])
            ->where('status', 'entregue')
            ->when($this->clienteId, function ($q) {
                $q->where('id_usuario', $this->clienteId);
            })
            ->when($this->categoriaId, function ($q) {
                $q->whereHas('itens.produto', function ($q2) {
                    $q2->where('id_categoria', $this->categoriaId);
                });
            })
            ->select(
                DB::raw('DATE(created_at) as data'),
                DB::raw('COUNT(*) as pedidos'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('data')
            ->orderBy('data')
            ->get();

        // Métodos de pagamento mais usados
        $metodosPagamento = Pedido::whereBetween('pedidos.created_at', [$dataInicio, $dataFim])
            ->join('pagamentos', 'pedidos.id_pedido', '=', 'pagamentos.id_pedido')
            ->when($this->metodoPagamento, function ($q) {
                $q->where('pagamentos.metodo', $this->metodoPagamento);
            })
            ->when($this->clienteId, function ($q) {
                $q->where('pedidos.id_usuario', $this->clienteId);
            })
            ->select('pagamentos.metodo', DB::raw('COUNT(*) as total'))
            ->groupBy('pagamentos.metodo')
            ->get();

        // Top produtos vendidos
        $topProdutos = DB::table('pedido_itens')
            ->join('pedidos', 'pedido_itens.id_pedido', '=', 'pedidos.id_pedido')
            ->join('produtos', 'pedido_itens.id_produto', '=', 'produtos.id_produto')
            ->whereBetween('pedidos.created_at', [$dataInicio, $dataFim])
            ->where('pedidos.status', 'entregue')
            ->when($this->categoriaId, function ($q) {
                $q->where('produtos.id_categoria', $this->categoriaId);
            })
            ->when($this->produtoId, function ($q) {
                $q->where('produtos.id_produto', $this->produtoId);
            })
            ->select(
                'produtos.id_produto',
                'produtos.nome',
                DB::raw('SUM(pedido_itens.quantidade) as quantidade_vendida'),
                DB::raw('SUM(pedido_itens.quantidade * pedido_itens.preco_unitario) as valor_total')
            )
            ->groupBy('produtos.id_produto', 'produtos.nome')
            ->orderByDesc('valor_total')
            ->limit(5)
            ->get();

        $this->dadosVendas = [
            'periodo' => [
                'inicio' => $dataInicio->format('d/m/Y'),
                'fim' => $dataFim->format('d/m/Y'),
            ],
            'totais' => [
                'vendas' => $totalVendas,
                'pedidos' => $totalPedidos,
                'entregues' => $pedidosEntregues,
                'ticketMedio' => $ticketMedio,
            ],
            'porStatus' => $vendasPorStatus,
            'porDia' => $vendasPorDia,
            'metodosPagamento' => $metodosPagamento,
            'topProdutos' => $topProdutos,
        ];
    }
}