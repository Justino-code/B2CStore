<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FavoritoFactory extends Factory
{
    protected $model = \App\Models\Favorito::class;

    public function definition()
    {
        return [
            'id_usuario' => \App\Models\Usuario::factory(),
            'id_produto' => \App\Models\Produto::factory(),
            'created_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
        ];
    }

    public function recente()
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => now()->subDays(rand(1, 7)),
            ];
        });
    }

    public function antigo()
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => $this->faker->dateTimeBetween('-6 months', '-3 months'),
            ];
        });
    }
}
