<?php
// database/factories/MarcaFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Marca>
 */
class MarcaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nome = $this->faker->unique()->company();
        
        return [
            'nome' => $nome,
            'slug' => Str::slug($nome),
            'descricao' => $this->faker->paragraph(),
            'logo_url' => $this->faker->imageUrl(200, 200, 'logo', true, $nome),
            'website' => $this->faker->url(),
            'ordem' => $this->faker->numberBetween(1, 100),
            'ativo' => true,
            'meta_title' => $this->faker->sentence(),
            'meta_description' => $this->faker->paragraph(),
        ];
    }
    
    /**
     * Indicate that the marca is inactive.
     */
    public function inativa(): static
    {
        return $this->state(fn (array $attributes) => [
            'ativo' => false,
        ]);
    }
}