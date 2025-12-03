<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CupomFactory extends Factory
{
    protected $model = \App\Models\Cupom::class;

    // Lista de prefixos para cupons
    private static $prefixos = ['ESCOLA', 'ALUNO', 'PROF', 'VOLTA', 'APROVEITE', 'DESCONTO', 'PROMO', 'ESTUDO'];

    // Array estático para rastrear códigos gerados durante a execução
    private static $codigosGerados = [];

    public function definition()
    {
        $tipos = ['percentual', 'fixo'];
        $tipo = $this->faker->randomElement($tipos);

        $valorDesconto = $tipo === 'percentual'
            ? $this->faker->randomElement([10, 15, 20, 25, 30])
            : $this->faker->randomElement([5, 10, 15, 20, 25, 50]);

        // Gerar código único
        do {
            $prefixo = $this->faker->randomElement(self::$prefixos);
            $numero = $this->faker->numberBetween(10, 99);
            $codigo = $prefixo . $numero;

            // Verificar também no banco de dados para garantir unicidade
            $existeNoBanco = \App\Models\Cupom::where('codigo', $codigo)->exists();
        } while (in_array($codigo, self::$codigosGerados) || $existeNoBanco);

        self::$codigosGerados[] = $codigo;

        return [
            'codigo' => $codigo,
            'tipo_desconto' => $tipo,
            'valor_desconto' => $valorDesconto,
            'valor_minimo' => $this->faker->boolean(60) ? $this->faker->numberBetween(50, 200) : null,
            'usos_maximos' => $this->faker->boolean(50) ? $this->faker->numberBetween(10, 100) : null,
            'usos_atual' => 0,
            'validade_inicio' => $this->faker->boolean(70) ? now()->subDays(10) : null,
            'validade_fim' => $this->faker->boolean(70) ? now()->addDays($this->faker->numberBetween(10, 60)) : null,
            'ativo' => $this->faker->boolean(90),
        ];
    }

    public function percentual($valor = 20)
    {
        return $this->state(function (array $attributes) use ($valor) {
            return [
                'tipo_desconto' => 'percentual',
                'valor_desconto' => $valor,
            ];
        });
    }

    public function fixo($valor = 15)
    {
        return $this->state(function (array $attributes) use ($valor) {
            return [
                'tipo_desconto' => 'fixo',
                'valor_desconto' => $valor,
            ];
        });
    }

    public function valido()
    {
        return $this->state(function (array $attributes) {
            return [
                'ativo' => true,
                'validade_fim' => now()->addDays(30),
                'usos_maximos' => 100,
                'usos_atual' => 0,
            ];
        });
    }

    public function expirado()
    {
        return $this->state(function (array $attributes) {
            return [
                'validade_fim' => now()->subDays(10),
                'ativo' => true,
            ];
        });
    }

    public function usadoCompletamente()
    {
        return $this->state(function (array $attributes) {
            return [
                'usos_maximos' => 10,
                'usos_atual' => 10,
                'ativo' => true,
            ];
        });
    }
}
