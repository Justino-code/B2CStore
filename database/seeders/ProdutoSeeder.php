<?php

namespace Database\Seeders;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    private $produtosPadrao = [
        [
            'nome' => 'Caderno Universitário 200 folhas',
            'descricao' => 'Caderno universitário espiral com 200 folhas, capa dura, ideal para faculdade',
            'preco' => 24.90,
            'preco_promocional' => 19.90,
            'sku' => 'SKU-1001',
            'estoque' => 50,
            'peso' => 0.5,
            'dimensoes' => '20x30x2',
            'ativo' => true,
            'destaque' => true,
        ],
        [
            'nome' => 'Caneta Esferográfica Azul Pack 10',
            'descricao' => 'Pack com 10 canetas esferográficas azuis, ponta média, tinta de qualidade',
            'preco' => 12.90,
            'preco_promocional' => null,
            'sku' => 'SKU-1002',
            'estoque' => 200,
            'peso' => 0.2,
            'dimensoes' => '15x10x3',
            'ativo' => true,
            'destaque' => false,
        ],
        [
            'nome' => 'Mochila Escolar com Rodinhas',
            'descricao' => 'Mochila escolar ergonômica com rodinhas, múltiplos compartimentos, resistente à água',
            'preco' => 129.90,
            'preco_promocional' => 99.90,
            'sku' => 'SKU-1003',
            'estoque' => 25,
            'peso' => 1.2,
            'dimensoes' => '40x30x20',
            'ativo' => true,
            'destaque' => true,
        ],
        [
            'nome' => 'Calculadora Científica HP 300s+',
            'descricao' => 'Calculadora científica com 300 funções, display de 2 linhas, ideal para ensino médio e superior',
            'preco' => 89.90,
            'preco_promocional' => 74.90,
            'sku' => 'SKU-1004',
            'estoque' => 30,
            'peso' => 0.3,
            'dimensoes' => '16x8x1',
            'ativo' => true,
            'destaque' => true,
        ],
        [
            'nome' => 'Kit Lápis de Cor 24 Cores',
            'descricao' => 'Kit completo com 24 lápis de cor de alta qualidade, cores vibrantes, ideal para artes',
            'preco' => 34.90,
            'preco_promocional' => 27.90,
            'sku' => 'SKU-1005',
            'estoque' => 40,
            'peso' => 0.4,
            'dimensoes' => '18x12x3',
            'ativo' => true,
            'destaque' => false,
        ],
        [
            'nome' => 'Uniforme Escolar - Camiseta Polo',
            'descricao' => 'Camiseta polo do uniforme escolar, tecido respirável, diversas cores disponíveis',
            'preco' => 39.90,
            'preco_promocional' => null,
            'sku' => 'SKU-1006',
            'estoque' => 100,
            'peso' => 0.3,
            'dimensoes' => '30x25x2',
            'ativo' => true,
            'destaque' => false,
        ],
    ];

    public function run()
    {
        $categorias = Categoria::all();

        // Criar produtos padrão
        foreach ($this->produtosPadrao as $index => $produtoData) {
            $categoria = $categorias->get($index % $categorias->count());

            Produto::firstOrCreate(
                ['sku' => $produtoData['sku']],
                array_merge($produtoData, [
                    'id_categoria' => $categoria->id_categoria,
                    'slug' => \Illuminate\Support\Str::slug($produtoData['nome']),
                ])
            );
        }

        // Criar 50 produtos aleatórios
        Produto::factory(50)->create();

        // Criar imagens para os produtos
        $this->call(ProdutoImagemSeeder::class);

        $this->command->info('✅ 56 produtos criados (6 padrão + 50 aleatórios)');
    }
}
