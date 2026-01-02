<?php

namespace Database\Seeders;

use App\Models\Produto;
use App\Models\ProdutoImagem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdutoImagemSeeder extends Seeder
{
    // Banco maior de imagens por categoria - 10 imagens por categoria
    private $imagensPorCategoria = [
        'Material Escolar' => [
            'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1581094791223-367e87b72d03?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1541789094915-5f40a5f0e4df?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1529245019870-59b249281fd3?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1536922246289-88c42f957773?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1565687538067-9fb84c3d54a2?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1622665711128-3c4e64f7201a?w=800&h=600&fit=crop&auto=format',
        ],
        'Livros Didáticos' => [
            'https://images.unsplash.com/photo-1541963463532-d68292c34b19?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1531346688376-ab6275c4725e?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1524578271613-d550eacf6090?w=800&h=600&fit=crop&auto=format',
        ],
        'Uniforme Escolar' => [
            'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1491975474562-1f4e30bc9468?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1520006403909-838d6b92c22e?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1552374196-c4e7ffc6e126?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1558769132-cb1c458e4222?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1542060748-10c28b62716f?w=800&h=600&fit=crop&auto=format',
        ],
        'Mochilas e Estojos' => [
            'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1541963463532-d68292c34b19?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1578303512597-81e6cc155b3e?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1531346688376-ab6275c4725e?w=800&h=600&fit=crop&auto=format',
        ],
        'Arte e Pintura' => [
            'https://images.unsplash.com/photo-1578303512597-81e6cc155b3e?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1541963463532-d68292c34b19?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=600&fit=crop&auto=format',
        ],
        'Tecnologia Educacional' => [
            'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1518779578993-ec3579fee39f?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1510519138101-570d1dca3d66?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1498049860654-af1a5c566876?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&h=600&fit=crop&auto=format',
        ],
        'Esportes Escolares' => [
            'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1552674605-db6ffd8facb5?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1536922246289-88c42f957773?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=600&fit=crop&auto=format',
        ],
        'Papelaria Criativa' => [
            'https://images.unsplash.com/photo-1531346688376-ab6275c4725e?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1581094791223-367e87b72d03?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1541789094915-5f40a5f0e4df?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1536922246289-88c42f957773?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1565687538067-9fb84c3d54a2?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1622665711128-3c4e64f7201a?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1541963463532-d68292c34b19?w=800&h=600&fit=crop&auto=format',
        ],
        'Brinquedos Educativos' => [
            'https://images.unsplash.com/photo-1594787317392-6ec0d0a16080?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1529255484355-cb73c33c04bb?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1561136598-b5bdd0b8b1c2?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1562771379-eafdca7a02f8?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1593560708920-61dd98c46a4e?w=800&h=600&fit=crop&auto=format',
        ],
        'Material Infantil' => [
            'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1594787317392-6ec0d0a16080?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1541963463532-d68292c34b19?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=600&fit=crop&auto=format',
        ],
        // Categorias genéricas para fallback
        'default' => [
            'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1541963463532-d68292c34b19?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1531346688376-ab6275c4725e?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1578303512597-81e6cc155b3e?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1594787317392-6ec0d0a16080?w=800&h=600&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=800&h=600&fit=crop&auto=format',
        ],
    ];

    public function run()
    {
        $this->command->info('🖼️  Iniciando criação de imagens para produtos...');
        
        // Limpar imagens existentes para recomeçar do zero
        DB::table('produto_imagens')->truncate();
        
        $produtos = Produto::with('categoria')->get();
        $totalImagens = 0;
        $produtosSemImagem = 0;
        
        // Para rastrear quais imagens já foram usadas por produto
        $imagensUsadasPorProduto = [];
        
        foreach ($produtos as $produto) {
            // Determinar número de imagens (produtos destaque têm mais)
            $numImagens = $produto->destaque ? rand(3, 4) : rand(1, 3);
            
            // Obter categoria do produto
            $categoriaNome = $produto->categoria->nome ?? 'Material Escolar';
            
            // Selecionar pool de imagens baseado na categoria
            $imagensDisponiveis = $this->imagensPorCategoria[$categoriaNome] ?? $this->imagensPorCategoria['default'];
            
            // Embaralhar para variedade - cada produto começa de uma posição diferente
            shuffle($imagensDisponiveis);
            
            // Garantir que temos imagens suficientes
            if (count($imagensDisponiveis) < $numImagens) {
                $imagensDisponiveis = array_merge(
                    $imagensDisponiveis,
                    $this->imagensPorCategoria['default']
                );
            }
            
            // Para este produto específico, vamos pegar imagens únicas
            $imagensParaEsteProduto = [];
            $tentativas = 0;
            $maxTentativas = count($imagensDisponiveis) * 2;
            
            while (count($imagensParaEsteProduto) < $numImagens && $tentativas < $maxTentativas) {
                // Pegar imagem aleatória do pool
                $imagemAleatoria = $imagensDisponiveis[array_rand($imagensDisponiveis)];
                
                // Verificar se esta imagem já foi usada para este produto
                if (!in_array($imagemAleatoria, $imagensParaEsteProduto)) {
                    $imagensParaEsteProduto[] = $imagemAleatoria;
                }
                
                $tentativas++;
            }
            
            // Se não conseguimos imagens únicas suficientes, completar com as primeiras disponíveis
            if (count($imagensParaEsteProduto) < $numImagens) {
                for ($i = count($imagensParaEsteProduto); $i < $numImagens; $i++) {
                    $imagensParaEsteProduto[] = $imagensDisponiveis[$i % count($imagensDisponiveis)];
                }
            }
            
            // Criar imagens para o produto
            $imagensCriadas = 0;
            foreach ($imagensParaEsteProduto as $index => $urlImagem) {
                try {
                    ProdutoImagem::create([
                        'id_produto' => $produto->id_produto,
                        'url_imagem' => $urlImagem,
                        'ordem' => $index + 1,
                        'principal' => $index === 0,
                    ]);
                    
                    $imagensCriadas++;
                    $totalImagens++;
                } catch (\Exception $e) {
                    // Ignorar erros de duplicação
                    if (strpos($e->getMessage(), 'Duplicate entry') === false) {
                        $this->command->warn("⚠️  Erro ao criar imagem para produto {$produto->id_produto}: " . $e->getMessage());
                    }
                }
            }
            
            if ($imagensCriadas === 0) {
                $produtosSemImagem++;
            }
            
            // Acompanhar progresso
            if ($produto->id_produto % 10 === 0) {
                $this->command->info("   📸 Processados {$produto->id_produto}/{$produtos->count()} produtos...");
            }
        }
        
        $this->command->info("\n✅ CONCLUSÃO:");
        $this->command->info("   🖼️  Total de imagens criadas: {$totalImagens}");
        $this->command->info("   🛍️  Produtos processados: {$produtos->count()}");
        
        if ($produtosSemImagem > 0) {
            $this->command->warn("   ⚠️  {$produtosSemImagem} produtos ficaram sem imagens");
        }
        
        // Estatísticas
        if ($produtos->count() > 0) {
            $mediaImagens = round($totalImagens / $produtos->count(), 1);
            $this->command->info("   📊 Média de imagens por produto: {$mediaImagens}");
            
            // Verificar variedade
            $imagensUnicas = ProdutoImagem::distinct('url_imagem')->count('url_imagem');
            $this->command->info("   🎨 Imagens únicas utilizadas: {$imagensUnicas}");
        }
    }
}