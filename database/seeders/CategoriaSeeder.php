<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    private $categoriasPadrao = [
        [
            'nome' => 'Material Escolar',
            'descricao' => 'Cadernos, canetas, lápis e outros materiais essenciais para estudantes',
            'imagem_url' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12',
            'ordem' => 1,
            'ativo' => true,
        ],
        [
            'nome' => 'Livros Didáticos',
            'descricao' => 'Livros para todas as disciplinas e níveis escolares',
            'imagem_url' => 'https://images.unsplash.com/photo-1541963463532-d68292c34b19',
            'ordem' => 2,
            'ativo' => true,
        ],
        [
            'nome' => 'Uniforme Escolar',
            'descricao' => 'Camisetas, calças, agasalhos e acessórios do uniforme',
            'imagem_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62',
            'ordem' => 3,
            'ativo' => true,
        ],
        [
            'nome' => 'Mochilas e Estojos',
            'descricao' => 'Mochilas, estojos, necessaires e bolsas escolares',
            'imagem_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62',
            'ordem' => 4,
            'ativo' => true,
        ],
        [
            'nome' => 'Arte e Pintura',
            'descricao' => 'Materiais para artes, pintura e trabalhos manuais',
            'imagem_url' => 'https://images.unsplash.com/photo-1541963463532-d68292c34b19',
            'ordem' => 5,
            'ativo' => true,
        ],
        [
            'nome' => 'Tecnologia e Eletrônicos',
            'descricao' => 'Calculadoras, tablets, headphones e acessórios eletrônicos',
            'imagem_url' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12',
            'ordem' => 6,
            'ativo' => true,
        ],
        [
            'nome' => 'Esportes',
            'descricao' => 'Materiais para educação física e atividades esportivas',
            'imagem_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62',
            'ordem' => 7,
            'ativo' => true,
        ],
        [
            'nome' => 'Papelaria',
            'descricao' => 'Papéis, envelopes, pastas e organizadores',
            'imagem_url' => 'https://images.unsplash.com/photo-1541963463532-d68292c34b19',
            'ordem' => 8,
            'ativo' => true,
        ],
    ];

    public function run()
    {
        $this->command->info('📁 Criando categorias padrão...');

        // Desabilitar verificação de chaves estrangeiras temporariamente
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($this->categoriasPadrao as $categoria) {
            Categoria::firstOrCreate(
                ['nome' => $categoria['nome']],
                $categoria
            );
        }

        $this->command->info('📁 Criando categorias aleatórias...');

        // Criar 5 categorias aleatórias
        for ($i = 0; $i < 5; $i++) {
            try {
                Categoria::factory()->create();
            } catch (\Exception $e) {
                $this->command->warn('⚠️  Erro ao criar categoria: ' . $e->getMessage());
            }
        }

        // Reabilitar verificação de chaves estrangeiras
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $totalCategorias = Categoria::count();
        $this->command->info("✅ Total: {$totalCategorias} categorias criadas");
    }
}
