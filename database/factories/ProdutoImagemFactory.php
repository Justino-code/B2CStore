<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoImagemFactory extends Factory
{
    protected $model = \App\Models\ProdutoImagem::class;

    public function definition()
    {
        $imagens = [
            'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158',
            'https://images.unsplash.com/photo-1581091226033-1686a5d8ed6c',
            'https://images.unsplash.com/photo-1581092580497-e0d4cb184827',
            'https://images.unsplash.com/photo-1581092581154-9c3d6b5c5b5e',
            'https://images.unsplash.com/photo-1581092580497-e0d4cb184827',
        ];

        return [
            'id_produto' => \App\Models\Produto::factory(),
            'url_imagem' => $this->faker->randomElement($imagens),
            'ordem' => $this->faker->numberBetween(1, 5),
            'principal' => $this->faker->boolean(20), // 20% de chance de ser principal
        ];
    }

    public function principal()
    {
        return $this->state(function (array $attributes) {
            return [
                'principal' => true,
                'ordem' => 1,
            ];
        });
    }

    public function secundaria()
    {
        return $this->state(function (array $attributes) {
            return [
                'principal' => false,
                'ordem' => $this->faker->numberBetween(2, 5),
            ];
        });
    }
}
