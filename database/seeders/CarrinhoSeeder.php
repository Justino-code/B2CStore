<?php

namespace Database\Seeders;

use App\Models\Carrinho;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class CarrinhoSeeder extends Seeder
{
    public function run()
    {
        $usuarios = Usuario::all();

        foreach ($usuarios as $usuario) {
            // Cada usuário tem um carrinho (se não existir)
            Carrinho::firstOrCreate([
                'id_usuario' => $usuario->id_usuario,
            ]);
        }

        // Adicionar itens aleatórios a alguns carrinhos
        $carrinhos = Carrinho::all();
        $carrinhosAleatorios = $carrinhos->random(min(10, $carrinhos->count()));

        foreach ($carrinhosAleatorios as $carrinho) {
            $this->adicionarItensAoCarrinho($carrinho);
        }

        $this->command->info('✅ Carrinhos criados para todos os usuários');
    }

    private function adicionarItensAoCarrinho($carrinho)
    {
        $produtos = \App\Models\Produto::ativos()->comEstoque()->get()->random(rand(1, 5));

        foreach ($produtos as $produto) {
            \App\Models\CarrinhoItem::firstOrCreate([
                'id_carrinho' => $carrinho->id_carrinho,
                'id_produto' => $produto->id_produto,
            ], [
                'quantidade' => rand(1, 3),
                'preco_unitario' => $produto->precoAtual(),
            ]);
        }
    }
}
