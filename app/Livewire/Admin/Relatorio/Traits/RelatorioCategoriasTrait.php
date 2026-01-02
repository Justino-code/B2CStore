<?php

namespace App\Livewire\Admin\Relatorio\Traits;

use App\Models\Categoria;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait RelatorioCategoriasTrait
{
    private function carregarRelatorioCategorias($dataInicio, $dataFim)
    {
        // Desempenho detalhado por categoria
        $desempenhoCategorias = DB::table('pedido_itens')
            ->join('pedidos', 'pedido_itens.id_pedido', '=', 'pedidos.id_pedido')
            ->join('produtos', 'pedido_itens.id_produto', '=', 'produtos.id_produto')
            ->join('categorias', 'produtos.id_categoria', '=', 'categorias.id_categoria')
            ->whereBetween('pedidos.created_at', [$dataInicio, $dataFim])
            ->where('pedidos.status', 'entregue')
            ->when($this->categoriaId, function ($query) {
                $query->where('categorias.id_categoria', $this->categoriaId);
            })
            ->select(
                'categorias.id_categoria',
                'categorias.nome',
                'categorias.ativo',
                DB::raw('COUNT(DISTINCT pedidos.id_pedido) as pedidos'),
                DB::raw('COUNT(DISTINCT produtos.id_produto) as produtos_vendidos'),
                DB::raw('SUM(pedido_itens.quantidade) as quantidade_total'),
                DB::raw('SUM(pedido_itens.quantidade * pedido_itens.preco_unitario) as valor_total'),
                DB::raw('AVG(pedido_itens.preco_unitario) as preco_medio')
            )
            ->groupBy('categorias.id_categoria', 'categorias.nome', 'categorias.ativo')
            ->orderByDesc('valor_total')
            ->get();

        // Categorias sem produtos vendidos
        $categoriasSemVendas = Categoria::where('ativo', true)
            ->when($this->categoriaId, function ($query) {
                $query->where('id_categoria', $this->categoriaId);
            })
            ->whereNotIn('id_categoria', function ($query) use ($dataInicio, $dataFim) {
                $query->select('categorias.id_categoria')
                    ->from('pedido_itens')
                    ->join('pedidos', 'pedido_itens.id_pedido', '=', 'pedidos.id_pedido')
                    ->join('produtos', 'pedido_itens.id_produto', '=', 'produtos.id_produto')
                    ->join('categorias', 'produtos.id_categoria', '=', 'categorias.id_categoria')
                    ->whereBetween('pedidos.created_at', [$dataInicio, $dataFim])
                    ->where('pedidos.status', 'entregue');
            })
            ->withCount('produtos')
            ->orderBy('nome')
            ->get();

        // Distribuição de produtos por categoria
        $distribuicaoProdutos = Categoria::withCount(['produtos as total_produtos' => function ($query) {
                $query->where('ativo', true);
            }])
            ->withCount(['produtos as produtos_ativos' => function ($query) {
                $query->where('ativo', true);
            }])
            ->withCount(['produtos as produtos_estoque_baixo' => function ($query) {
                $query->where('ativo', true)->where('estoque', '<', 10);
            }])
            ->orderByDesc('total_produtos')
            ->get();

        $this->dadosCategorias = [
            'desempenhoCategorias' => $desempenhoCategorias,
            'categoriasSemVendas' => $categoriasSemVendas,
            'distribuicaoProdutos' => $distribuicaoProdutos,
        ];
    }
}