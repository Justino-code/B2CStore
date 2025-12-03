<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarrinhoFactory extends Factory
{
    protected $model = \App\Models\Carrinho::class;

    public function definition()
    {
        return [
            'id_usuario' => \App\Models\Usuario::factory(),
        ];
    }

    public function comItens($count = 3)
    {
        return $this->afterCreating(function (\App\Models\Carrinho $carrinho) use ($count) {
            \App\Models\Produto::factory($count)
                ->comEstoque()
                ->create()
                ->each(function ($produto) use ($carrinho) {
                    \App\Models\CarrinhoItem::factory()->create([
                        'id_carrinho' => $carrinho->id_carrinho,
                        'id_produto' => $produto->id_produto,
                        'quantidade' => rand(1, 3),
                        'preco_unitario' => $produto->precoAtual(),
                    ]);
                });
        });
    }

    public function vazio()
    {
        return $this->state(function (array $attributes) {
            return [];
        });
    }
}
