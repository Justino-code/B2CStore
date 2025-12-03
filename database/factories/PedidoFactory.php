<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    protected $model = \App\Models\Pedido::class;

    public function definition()
    {
        $statuses = ['pendente', 'pago', 'processando', 'enviado', 'entregue', 'cancelado'];

        return [
            'id_usuario' => \App\Models\Usuario::factory(),
            'id_cupom' => $this->faker->boolean(30) ? \App\Models\Cupom::factory() : null,
            'codigo_pedido' => 'PED-' . strtoupper(uniqid()),
            'total' => $this->faker->numberBetween(50, 500),
            'custo_envio' => $this->faker->numberBetween(10, 50),
            'valor_desconto' => $this->faker->numberBetween(0, 50),
            'status' => $this->faker->randomElement($statuses),
            'endereco_entrega' => $this->faker->address(),
            'metodo_envio' => $this->faker->randomElement(['Correios', 'Transportadora', 'Retirada']),
            'data_entrega' => $this->faker->boolean(60) ? now()->addDays($this->faker->numberBetween(1, 7)) : null,
            'observacoes' => $this->faker->boolean(20) ? $this->faker->sentence() : null,
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function comItens($count = 3)
    {
        return $this->afterCreating(function (\App\Models\Pedido $pedido) use ($count) {
            \App\Models\Produto::factory($count)
                ->create()
                ->each(function ($produto) use ($pedido) {
                    \App\Models\PedidoItem::factory()->create([
                        'id_pedido' => $pedido->id_pedido,
                        'id_produto' => $produto->id_produto,
                        'quantidade' => rand(1, 3),
                        'preco_unitario' => $produto->precoAtual(),
                    ]);
                });
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

    public function pago()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pago',
            ];
        });
    }

    public function enviado()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'enviado',
                'data_entrega' => now()->addDays(3),
            ];
        });
    }

    public function entregue()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'entregue',
                'data_entrega' => now()->subDays(3),
            ];
        });
    }

    public function cancelado()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'cancelado',
            ];
        });
    }

    public function recente()
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => now()->subDays(rand(1, 7)),
            ];
        });
    }
}
