<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = \App\Models\Review::class;

    public function definition()
    {
        return [
            'id_produto' => \App\Models\Produto::factory(),
            'id_usuario' => \App\Models\Usuario::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comentario' => $this->faker->boolean(70) ? $this->faker->paragraph() : null,
            'aprovado' => $this->faker->boolean(80),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }

    public function aprovado()
    {
        return $this->state(function (array $attributes) {
            return [
                'aprovado' => true,
            ];
        });
    }

    public function naoAprovado()
    {
        return $this->state(function (array $attributes) {
            return [
                'aprovado' => false,
            ];
        });
    }

    public function ratingAlto()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => $this->faker->numberBetween(4, 5),
            ];
        });
    }

    public function ratingBaixo()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => $this->faker->numberBetween(1, 2),
            ];
        });
    }

    public function comComentario()
    {
        return $this->state(function (array $attributes) {
            return [
                'comentario' => $this->faker->paragraphs(2, true),
            ];
        });
    }
}
