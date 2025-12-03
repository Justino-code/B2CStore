<?php

namespace Database\Seeders;

use App\Models\Produto;
use App\Models\ProdutoImagem;
use Illuminate\Database\Seeder;

class ProdutoImagemSeeder extends Seeder
{
    private $imagensPadrao = [
        'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w-800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1541963463532-d68292c34b19?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&h=600&fit=crop',
        'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=600&fit=crop',
    ];

    public function run()
    {
        $produtos = Produto::all();

        foreach ($produtos as $produto) {
            // Criar 1-4 imagens para cada produto
            $numImagens = rand(1, 4);

            for ($i = 0; $i < $numImagens; $i++) {
                ProdutoImagem::create([
                    'id_produto' => $produto->id_produto,
                    'url_imagem' => $this->imagensPadrao[array_rand($this->imagensPadrao)],
                    'ordem' => $i + 1,
                    'principal' => $i === 0, // Primeira imagem é a principal
                ]);
            }
        }

        $this->command->info('✅ Imagens criadas para todos os produtos');
    }
}
