<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        // Criar 20 usuários clientes
        Usuario::factory(20)->cliente()->create();

        // Criar alguns usuários específicos para testes
        $usuariosTeste = [
            [
                'nome' => 'João Silva',
                'email' => 'joao@email.com',
                'senha' => Hash::make('senha123'),
                'telefone' => '(11) 99999-8888',
                'role' => 'cliente',
            ],
            [
                'nome' => 'Maria Santos',
                'email' => 'maria@email.com',
                'senha' => Hash::make('senha123'),
                'telefone' => '(11) 99999-7777',
                'role' => 'cliente',
            ],
        ];

        foreach ($usuariosTeste as $usuario) {
            Usuario::firstOrCreate(
                ['email' => $usuario['email']],
                $usuario
            );
        }

        $this->command->info('✅ 22 usuários criados (20 aleatórios + 2 específicos)');
    }
}
