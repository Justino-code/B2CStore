<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoItemFactory extends Factory
{
    protected $model = \App\Models\PedidoItem::class;

    public function definition()
    {
        $produto = \App\Models\Produto::factory()->create();

        return [
            'id_pedido' => \App\Models\Pedido::factory(),
            'id_produto' => $produto->id_produto,
            'quantidade' => $this->faker->numberBetween(1, 5),
            'preco_unitario' => $produto->precoAtual(),
        ];
    }

    public function quantidadeAlta()
    {
        return $this->state(function (array $attributes) {
            return [
                'quantidade' => $this->faker->numberBetween(10, 20),
            ];
        });
    }
}
