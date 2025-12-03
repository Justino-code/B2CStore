<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PagamentoFactory extends Factory
{
    protected $model = \App\Models\Pagamento::class;

    public function definition()
    {
        $metodos = ['cartao', 'pix', 'boleto', 'transferencia'];
        $statuses = ['pendente', 'pago', 'falhou', 'reembolsado'];

        return [
            'id_pedido' => \App\Models\Pedido::factory(),
            'metodo' => $this->faker->randomElement($metodos),
            'status' => $this->faker->randomElement($statuses),
            'valor' => $this->faker->numberBetween(50, 500),
            'transacao_id' => 'TRX-' . strtoupper(uniqid()),
            'detalhes' => [
                'metodo' => $this->faker->creditCardType(),
                'ultimos_digitos' => $this->faker->numberBetween(1000, 9999),
                'parcelas' => $this->faker->numberBetween(1, 12),
            ],
        ];
    }

    public function aprovado()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pago',
                'detalhes' => [
                    'autorizacao' => strtoupper(uniqid()),
                    'data_aprovacao' => now()->toDateTimeString(),
                ],
            ];
        });
    }

    public function pendente()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pendente',
            ];
        });
    }

    public function falhou()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'falhou',
                'detalhes' => [
                    'motivo' => $this->faker->randomElement([
                        'Saldo insuficiente',
                        'Cartão expirado',
                        'Transação recusada',
                        'Limite excedido'
                    ]),
                ],
            ];
        });
    }

    public function cartao()
    {
        return $this->state(function (array $attributes) {
            return [
                'metodo' => 'cartao',
                'detalhes' => [
                    'metodo' => $this->faker->creditCardType(),
                    'ultimos_digitos' => $this->faker->numberBetween(1000, 9999),
                    'parcelas' => $this->faker->numberBetween(1, 12),
                ],
            ];
        });
    }

    public function pix()
    {
        return $this->state(function (array $attributes) {
            return [
                'metodo' => 'pix',
                'detalhes' => [
                    'chave' => $this->faker->email(),
                    'copia_cola' => $this->faker->uuid(),
                    'qr_code' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . $this->faker->uuid(),
                ],
            ];
        });
    }
}
