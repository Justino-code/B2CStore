<?php

namespace Database\Seeders;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    private $produtosPadrao = [
        [
            'nome' => 'Caderno Universitário 200 Folhas Espiral',
            'descricao' => 'Caderno universitário espiral premium com 200 folhas, capa dura resistente, ideal para faculdade e cursos técnicos. Folhas com margens delineadas e papel de alta gramatura.',
            'preco' => 24.90,
            'preco_promocional' => 19.90,
            'sku' => 'SKU-CAD-200',
            'estoque' => 150,
            'peso' => 0.5,
            'dimensoes' => '21x29.7x2',
            'ativo' => true,
            'destaque' => true,
        ],
        [
            'nome' => 'Caneta Esferográfica Azul Pack 10 Unidades',
            'descricao' => 'Pack econômico com 10 canetas esferográficas azuis, ponta média, tinta de alta qualidade. Escrita suave e sem falhas, ideal para uso escolar e escritório.',
            'preco' => 12.90,
            'preco_promocional' => 9.90,
            'sku' => 'SKU-CAN-10PK',
            'estoque' => 500,
            'peso' => 0.2,
            'dimensoes' => '15x10x3',
            'ativo' => true,
            'destaque' => false,
        ],
        [
            'nome' => 'Mochila Escolar Impermeável com Rodinhas',
            'descricao' => 'Mochila escolar ergonômica com sistema de rodinhas retráteis, múltiplos compartimentos organizadores, alças acolchoadas e material impermeável.',
            'preco' => 189.90,
            'preco_promocional' => 149.90,
            'sku' => 'SKU-MCH-ROD',
            'estoque' => 75,
            'peso' => 1.5,
            'dimensoes' => '45x35x25',
            'ativo' => true,
            'destaque' => true,
        ],
        [
            'nome' => 'Calculadora Científica HP 300s+ 300 Funções',
            'descricao' => 'Calculadora científica profissional com 300 funções, display LCD de 2 linhas, memória de 9 variáveis. Ideal para ensino médio, superior e concursos.',
            'preco' => 129.90,
            'preco_promocional' => 109.90,
            'sku' => 'SKU-CALC-HP300',
            'estoque' => 60,
            'peso' => 0.35,
            'dimensoes' => '16.5x8.5x1.5',
            'ativo' => true,
            'destaque' => true,
        ],
        [
            'nome' => 'Kit Profissional Lápis de Cor 36 Cores',
            'descricao' => 'Kit completo com 36 lápis de cor profissionais, cores vibrantes e altamente pigmentadas, madeira de qualidade e mina resistente.',
            'preco' => 89.90,
            'preco_promocional' => 69.90,
            'sku' => 'SKU-LAPIS-36',
            'estoque' => 120,
            'peso' => 0.8,
            'dimensoes' => '25x18x5',
            'ativo' => true,
            'destaque' => true,
        ],
        [
            'nome' => 'Uniforme Escolar Camiseta Polo Dry Fit',
            'descricao' => 'Camiseta polo do uniforme escolar em tecido dry fit, tecnologia antibacteriana e proteção UV. Disponível em várias cores e tamanhos.',
            'preco' => 49.90,
            'preco_promocional' => 39.90,
            'sku' => 'SKU-POLO-DRY',
            'estoque' => 300,
            'peso' => 0.25,
            'dimensoes' => '30x25x2',
            'ativo' => true,
            'destaque' => false,
        ],
        [
            'nome' => 'Tablet Educacional Kids 7" com Capa',
            'descricao' => 'Tablet educacional infantil 7 polegadas com sistema de controle parental, 64GB, processador quad-core. Inclui apps educativos e capa protetora.',
            'preco' => 499.90,
            'preco_promocional' => 399.90,
            'sku' => 'SKU-TAB-KIDS',
            'estoque' => 40,
            'peso' => 0.65,
            'dimensoes' => '19x12x1',
            'ativo' => true,
            'destaque' => true,
        ],
        [
            'nome' => 'Bola de Futebol Oficial Tamanho 5',
            'descricao' => 'Bola de futebol oficial tamanho 5, material PU de alta resistência, costura hand stitched, apropriada para competições escolares.',
            'preco' => 79.90,
            'preco_promocional' => 64.90,
            'sku' => 'SKU-BOLA-FUT',
            'estoque' => 90,
            'peso' => 0.45,
            'dimensoes' => '22x22x22',
            'ativo' => true,
            'destaque' => false,
        ],
    ];

    public function run()
    {
        $this->command->info('🛍️  Iniciando criação de produtos...');
        
        $categorias = Categoria::all();
        
        if ($categorias->isEmpty()) {
            $this->command->warn('⚠️  Nenhuma categoria encontrada. Criando produtos sem categoria...');
        }
        
        // Mapear produtos para categorias específicas
        $mapeamentoCategorias = [
            'SKU-CAD-200' => 'Material Escolar',
            'SKU-CAN-10PK' => 'Material Escolar',
            'SKU-MCH-ROD' => 'Mochilas e Estojos',
            'SKU-CALC-HP300' => 'Tecnologia Educacional',
            'SKU-LAPIS-36' => 'Arte e Pintura',
            'SKU-POLO-DRY' => 'Uniforme Escolar',
            'SKU-TAB-KIDS' => 'Tecnologia Educacional',
            'SKU-BOLA-FUT' => 'Esportes Escolares',
        ];
        
        // Criar produtos padrão
        $produtosPadraoCriados = 0;
        foreach ($this->produtosPadrao as $produtoData) {
            $sku = $produtoData['sku'];
            
            // Encontrar categoria apropriada
            $id_categoria = null;
            if (!$categorias->isEmpty()) {
                $categoriaNome = $mapeamentoCategorias[$sku] ?? 'Material Escolar';
                $categoria = $categorias->firstWhere('nome', $categoriaNome);
                
                if (!$categoria) {
                    $categoria = $categorias->first();
                }
                
                $id_categoria = $categoria->id_categoria;
            }
            
            // Criar produto mantendo o slug do original
            $produto = Produto::firstOrCreate(
                ['sku' => $sku],
                array_merge($produtoData, [
                    'id_categoria' => $id_categoria,
                    'slug' => \Illuminate\Support\Str::slug($produtoData['nome']),
                ])
            );
            
            if ($produto->wasRecentlyCreated) {
                $produtosPadraoCriados++;
                $this->command->info("   ✅ {$produtoData['nome']}");
            } else {
                $this->command->info("   🔄 Atualizado: {$produtoData['nome']}");
            }
        }
        
        $this->command->info("\n🛍️  Criando produtos aleatórios...");
        
        // Criar 50 produtos aleatórios distribuídos por categorias
        $produtosAleatoriosCriados = 0;
        $produtosPorCategoria = $categorias->isEmpty() ? 50 : ceil(50 / $categorias->count());
        
        foreach ($categorias as $categoria) {
            for ($i = 0; $i < $produtosPorCategoria && $produtosAleatoriosCriados < 50; $i++) {
                try {
                    Produto::factory()->create([
                        'id_categoria' => $categoria->id_categoria,
                    ]);
                    $produtosAleatoriosCriados++;
                } catch (\Exception $e) {
                    if (strpos($e->getMessage(), 'Duplicate entry') === false) {
                        $this->command->warn("⚠️  Erro ao criar produto: " . $e->getMessage());
                    }
                }
            }
            
            if ($produtosAleatoriosCriados >= 50) break;
        }
        
        // Se não há categorias, criar produtos sem categoria
        if ($categorias->isEmpty() && $produtosAleatoriosCriados < 50) {
            for ($i = $produtosAleatoriosCriados; $i < 50; $i++) {
                try {
                    Produto::factory()->create([
                        'id_categoria' => null,
                    ]);
                    $produtosAleatoriosCriados++;
                } catch (\Exception $e) {
                    $this->command->warn("⚠️  Erro ao criar produto sem categoria: " . $e->getMessage());
                }
            }
        }
        
        // Criar imagens para os produtos
        $this->command->info("\n🖼️  Criando imagens para produtos...");
        $this->call(ProdutoImagemSeeder::class);
        
        $totalProdutos = Produto::count();
        $produtosDestaque = Produto::where('destaque', true)->count();
        
        $this->command->info("\n📊 RESUMO:");
        $this->command->info("   🛍️  Total de produtos: {$totalProdutos}");
        $this->command->info("   ⭐ Produtos em destaque: {$produtosDestaque}");
        $this->command->info("   📦 Produtos padrão: {$produtosPadraoCriados}");
        $this->command->info("   🎲 Produtos aleatórios: {$produtosAleatoriosCriados}");
    }
}