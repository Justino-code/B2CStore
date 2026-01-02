<?php

namespace App\Livewire\Admin\Relatorio\Traits;

use App\Models\Produto;
use App\Models\Categoria;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait RelatorioProdutosTrait
{
    private function carregarRelatorioProdutos($dataInicio, $dataFim)
    {
        // Produtos mais vendidos com filtros
        $produtosMaisVendidos = DB::table('pedido_itens')
            ->join('pedidos', 'pedido_itens.id_pedido', '=', 'pedidos.id_pedido')
            ->join('produtos', 'pedido_itens.id_produto', '=', 'produtos.id_produto')
            ->whereBetween('pedidos.created_at', [$dataInicio, $dataFim])
            ->where('pedidos.status', 'entregue')
            ->when($this->categoriaId, function ($query) {
                $query->where('produtos.id_categoria', $this->categoriaId);
            })
            ->when($this->produtoId, function ($query) {
                $query->where('produtos.id_produto', $this->produtoId);
            })
            ->select(
                'produtos.id_produto',
                'produtos.nome',
                'produtos.sku',
                'produtos.preco',
                DB::raw('SUM(pedido_itens.quantidade) as quantidade_vendida'),
                DB::raw('SUM(pedido_itens.quantidade * pedido_itens.preco_unitario) as valor_total'),
                DB::raw('AVG(pedido_itens.preco_unitario) as preco_medio_vendido')
            )
            ->groupBy('produtos.id_produto', 'produtos.nome', 'produtos.sku', 'produtos.preco')
            ->when($this->ordenarPor, function ($query) {
                $direcao = $this->direcaoOrdenacao === 'desc' ? 'desc' : 'asc';
                $query->orderBy($this->ordenarPor, $direcao);
            }, function ($query) {
                $query->orderByDesc('valor_total');
            })
            ->limit(15)
            ->get();

        // Produtos com estoque baixo
        $estoqueBaixo = Produto::where('ativo', true)
            ->when($this->categoriaId, function ($query) {
                $query->where('id_categoria', $this->categoriaId);
            })
            ->where('estoque', '<', 10)
            ->orderBy('estoque')
            ->get(['id_produto', 'nome', 'sku', 'estoque', 'preco', 'id_categoria']);

        // Produtos nunca vendidos no período
        $produtosNuncaVendidos = Produto::where('ativo', true)
            ->when($this->categoriaId, function ($query) {
                $query->where('id_categoria', $this->categoriaId);
            })
            ->when($this->produtoId, function ($query) {
                $query->where('id_produto', $this->produtoId);
            })
            ->whereNotIn('id_produto', function ($query) use ($dataInicio, $dataFim) {
                $query->select('pedido_itens.id_produto')
                    ->from('pedido_itens')
                    ->join('pedidos', 'pedido_itens.id_pedido', '=', 'pedidos.id_pedido')
                    ->whereBetween('pedidos.created_at', [$dataInicio, $dataFim])
                    ->where('pedidos.status', 'entregue');
            })
            ->orderBy('nome')
            ->limit(10)
            ->get(['id_produto', 'nome', 'sku', 'estoque', 'preco']);

        // Desempenho por categoria
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
                DB::raw('COUNT(DISTINCT pedidos.id_pedido) as pedidos'),
                DB::raw('SUM(pedido_itens.quantidade) as produtos_vendidos'),
                DB::raw('SUM(pedido_itens.quantidade * pedido_itens.preco_unitario) as valor_total')
            )
            ->groupBy('categorias.id_categoria', 'categorias.nome')
            ->orderByDesc('valor_total')
            ->get();

        $this->dadosProdutos = [
            'produtosMaisVendidos' => $produtosMaisVendidos,
            'estoqueBaixo' => $estoqueBaixo,
            'produtosNuncaVendidos' => $produtosNuncaVendidos,
            'desempenhoCategorias' => $desempenhoCategorias,
        ];
    }
}