<?php

namespace Database\Seeders;

use App\Models\Favorito;
use App\Models\Usuario;
use App\Models\Produto;
use Illuminate\Database\Seeder;

class FavoritoSeeder extends Seeder
{
    public function run()
    {
        $usuarios = Usuario::where('role', 'cliente')->get();
        $produtos = Produto::ativos()->get();

        // Cada usuário terá 0-10 produtos favoritados
        foreach ($usuarios as $usuario) {
            $numFavoritos = rand(0, 10);
            $produtosAleatorios = $produtos->random(min($numFavoritos, $produtos->count()));

            foreach ($produtosAleatorios as $produto) {
                Favorito::firstOrCreate([
                    'id_usuario' => $usuario->id_usuario,
                    'id_produto' => $produto->id_produto,
                ]);
            }
        }

        $this->command->info('✅ Favoritos criados para usuários aleatórios');
    }
}
