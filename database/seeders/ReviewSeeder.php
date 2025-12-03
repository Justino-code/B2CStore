<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Produto;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $produtos = Produto::all();
        $usuarios = Usuario::where('role', 'cliente')->get();

        // Criar reviews para 70% dos produtos
        foreach ($produtos as $produto) {
            if (rand(1, 10) <= 7) { // 70% de chance
                $numReviews = rand(1, 8);
                $usuariosAleatorios = $usuarios->random(min($numReviews, $usuarios->count()));

                foreach ($usuariosAleatorios as $usuario) {
                    Review::firstOrCreate([
                        'id_produto' => $produto->id_produto,
                        'id_usuario' => $usuario->id_usuario,
                    ], [
                        'rating' => rand(3, 5), // Reviews geralmente positivas
                        'comentario' => $this->getComentarioAleatorio(),
                        'aprovado' => true,
                    ]);
                }
            }
        }

        $this->command->info('✅ Reviews criadas para produtos aleatórios');
    }

    private function getComentarioAleatorio()
    {
        $comentarios = [
            'Produto de excelente qualidade, superou minhas expectativas!',
            'Muito bom, entrega rápida e produto conforme descrição.',
            'Recomendo a todos, vale cada centavo.',
            'Bom custo-benefício, atende perfeitamente minhas necessidades.',
            'Material resistente e duradouro, perfeito para uso escolar.',
            'Chegou antes do prazo, embalagem perfeita.',
            'Produto exatamente como nas fotos, muito satisfeito.',
            'Qualidade superior, recomendo a loja.',
            'Bom atendimento e produto de qualidade.',
            'Comprarei novamente, produto excelente.',
        ];

        return $comentarios[array_rand($comentarios)];
    }
}
