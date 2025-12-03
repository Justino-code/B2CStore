<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarrinhoItemFactory extends Factory
{
    protected $model = \App\Models\CarrinhoItem::class;

    public function definition()
    {
        $produto = \App\Models\Produto::factory()->create();

        return [
            'id_carrinho' => \App\Models\Carrinho::factory(),
            'id_produto' => $produto->id_produto,
            'quantidade' => $this->faker->numberBetween(1, 5),
            'preco_unitario' => $produto->precoAtual(),
        ];
    }

    public function comProduto($produtoId)
    {
        $produto = \App\Models\Produto::find($produtoId);

        return $this->state(function (array $attributes) use ($produto) {
            return [
                'id_produto' => $produto->id_produto,
                'preco_unitario' => $produto->precoAtual(),
            ];
        });
    }

    public function quantidadeAlta()
    {
        return $this->state(function (array $attributes) {
            return [
                'quantidade' => $this->faker->numberBetween(5, 20),
            ];
        });
    }
}
