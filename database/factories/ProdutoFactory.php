<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProdutoFactory extends Factory
{
    protected $model = \App\Models\Produto::class;

    private $produtosEscolares = [
        'Caderno Universitário 200 folhas',
        'Caneta Esferográfica Azul',
        'Lápis Preto HB',
        'Borracha Branca',
        'Apontador com depósito',
        'Régua 30cm Transparente',
        'Compasso de Precisão',
        'Transferidor 180°',
        'Mochila Escolar com Rodinhas',
        'Estojo Escolar',
        'Calculadora Científica',
        'Dicionário Português',
        'Livro de Português 8º Ano',
        'Uniforme Escolar',
        'Tênis Esportivo',
        'Lápis de Cor 12 cores',
        'Giz de Cera',
        'Tinta Guache',
        'Pincel Número 8',
        'Bloco de Desenho A4',
        'Cola Bastão',
        'Tesoura sem Ponta',
        'Marca-texto Amarelo',
        'Post-it Adesivo',
        'Fichário 4 Anéis',
        'Papel Sulfite A4',
        'Cartolina Colorida',
        'EVA Colorido',
        'Pasta Catálogo',
        'Agenda Escolar'
    ];

    public function definition()
    {
        $preco = $this->faker->numberBetween(10, 500);
        $temPromocao = $this->faker->boolean(30);

        // Usar produto base com timestamp para garantir unicidade
        $produtoBase = $this->faker->randomElement($this->produtosEscolares);
        $nome = $produtoBase . ' ' . Str::random(3) . ' ' . time();

        $slug = Str::slug($nome) . '-' . uniqid();

        return [
            'id_categoria' => \App\Models\Categoria::inRandomOrder()->first()->id_categoria,
            'nome' => $nome,
            'descricao' => $this->faker->paragraphs(3, true),
            'preco' => $preco,
            'preco_promocional' => $temPromocao ? $preco * 0.8 : null,
            'sku' => 'SKU-' . uniqid(),
            'estoque' => $this->faker->numberBetween(0, 100),
            'peso' => $this->faker->randomFloat(2, 0.1, 5),
            'dimensoes' => $this->faker->randomElement(['10x15x2', '20x30x5', '15x20x3', '5x10x1']),
            'slug' => $slug,
            'ativo' => $this->faker->boolean(95),
            'destaque' => $this->faker->boolean(20),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function comEstoque()
    {
        return $this->state(function (array $attributes) {
            return [
                'estoque' => $this->faker->numberBetween(10, 100),
            ];
        });
    }

    public function semEstoque()
    {
        return $this->state(function (array $attributes) {
            return [
                'estoque' => 0,
            ];
        });
    }

    public function emPromocao()
    {
        return $this->state(function (array $attributes) {
            $preco = $this->faker->numberBetween(10, 500);
            return [
                'preco' => $preco,
                'preco_promocional' => $preco * 0.7,
            ];
        });
    }

    public function destaque()
    {
        return $this->state(function (array $attributes) {
            return [
                'destaque' => true,
            ];
        });
    }

    public function inativo()
    {
        return $this->state(function (array $attributes) {
            return [
                'ativo' => false,
            ];
        });
    }
}
