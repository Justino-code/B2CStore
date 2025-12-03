<?php

namespace Database\Seeders;

use App\Models\Pedido;
use App\Models\Usuario;
use App\Models\Cupom;
use Illuminate\Database\Seeder;

class PedidoSeeder extends Seeder
{
    public function run()
    {
        $usuarios = Usuario::where('role', 'cliente')->get();
        $cupons = Cupom::ativos()->get();

        // Criar 30 pedidos
        Pedido::factory(30)->create();

        // Atribuir alguns cupons a pedidos aleatórios
        $pedidos = Pedido::all();
        foreach ($pedidos as $pedido) {
            if (rand(0, 1) && $cupons->count() > 0) {
                $cupom = $cupons->random();
                $pedido->update([
                    'id_cupom' => $cupom->id_cupom,
                    'valor_desconto' => $cupom->calcularDesconto($pedido->total),
                ]);

                // Incrementar uso do cupom
                $cupom->increment('usos_atual');
            }
        }

        // Criar itens para os pedidos
        $this->command->call('db:seed', ['--class' => 'PedidoItemSeeder']);

        // Criar pagamentos para os pedidos
        $this->command->call('db:seed', ['--class' => 'PagamentoSeeder']);

        $this->command->info('✅ 30 pedidos criados com itens e pagamentos');
    }
}
