<?php

namespace Database\Seeders;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Produto;
use Illuminate\Database\Seeder;

class PedidoItemSeeder extends Seeder
{
    public function run()
    {
        $pedidos = Pedido::all();
        $produtos = Produto::ativos()->get();

        foreach ($pedidos as $pedido) {
            // Cada pedido terá 1-5 itens
            $numItens = rand(1, 5);
            $produtosPedido = $produtos->random($numItens);

            foreach ($produtosPedido as $produto) {
                PedidoItem::create([
                    'id_pedido' => $pedido->id_pedido,
                    'id_produto' => $produto->id_produto,
                    'quantidade' => rand(1, 3),
                    'preco_unitario' => $produto->precoAtual(),
                ]);
            }

            // Atualizar o total do pedido baseado nos itens
            $totalItens = $pedido->itens()->sum(\DB::raw('quantidade * preco_unitario'));
            $pedido->update([
                'total' => $totalItens + $pedido->custo_envio - $pedido->valor_desconto,
            ]);
        }

        $this->command->info('✅ Itens criados para todos os pedidos');
    }
}
