<?php

namespace Database\Seeders;

use App\Models\Pedido;
use App\Models\Pagamento;
use Illuminate\Database\Seeder;

class PagamentoSeeder extends Seeder
{
    public function run()
    {
        $pedidos = Pedido::all();

        foreach ($pedidos as $pedido) {
            $status = $pedido->status === 'cancelado' ? 'falhou' :
                     (in_array($pedido->status, ['pendente']) ? 'pendente' : 'pago');

            Pagamento::create([
                'id_pedido' => $pedido->id_pedido,
                'metodo' => $this->getMetodoAleatorio(),
                'status' => $status,
                'valor' => $pedido->total,
                'transacao_id' => 'TRX-' . strtoupper(uniqid()),
                'detalhes' => $this->getDetalhesPagamento(),
            ]);
        }

        $this->command->info('✅ Pagamentos criados para todos os pedidos');
    }

    private function getMetodoAleatorio()
    {
        $metodos = ['cartao', 'pix', 'boleto', 'transferencia'];
        return $metodos[array_rand($metodos)];
    }

    private function getDetalhesPagamento()
    {
        $metodo = $this->getMetodoAleatorio();

        $detalhes = [
            'cartao' => [
                'bandeira' => 'Visa',
                'ultimos_digitos' => rand(1000, 9999),
                'parcelas' => rand(1, 12),
            ],
            'pix' => [
                'chave' => 'pix@b2cstore.com',
                'copia_cola' => uniqid(),
            ],
            'boleto' => [
                'codigo_barras' => str_repeat(rand(0, 9), 44),
                'vencimento' => now()->addDays(3)->format('Y-m-d'),
            ],
            'transferencia' => [
                'banco' => 'Banco B2C',
                'agencia' => '0001',
                'conta' => '12345-6',
            ],
        ];

        return $detalhes[$metodo];
    }
}
