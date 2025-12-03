<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory
{
    protected $model = \App\Models\Usuario::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verificado_em' => now(),
            'senha' => Hash::make('senha123'), // senha padrão para testes
            'telefone' => $this->faker->phoneNumber(),
            'endereco' => $this->faker->address(),
            'avatar_url' => $this->faker->imageUrl(200, 200, 'people'),
            'remember_token' => Str::random(10),
            'role' => $this->faker->randomElement(['cliente', 'admin']),
        ];
    }

    public function cliente()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'cliente',
            ];
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
                'email' => 'admin@b2cstore.com',
            ];
        });
    }

    public function naoVerificado()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verificado_em' => null,
            ];
        });
    }
}
