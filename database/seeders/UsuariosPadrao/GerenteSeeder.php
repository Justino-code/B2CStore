<?php

namespace Database\Seeders\UsuariosPadrao;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GerenteSeeder extends Seeder
{
    public function run()
    {
        $gerente = Usuario::firstOrCreate(
            ['email' => 'gerente@b2cstore.com'],
            [
                'nome' => 'Gerente Geral B2CStore',
                'senha' => Hash::make('gerente123'),
                'telefone' => '(11) 98888-8888',
                'endereco' => 'Av. Paulista, 1000 - São Paulo/SP',
                'avatar_url' => 'https://ui-avatars.com/api/?name=Gerente+B2C&background=10B981&color=fff',
                'role' => 'gerente',
                'email_verificado_em' => now(),
            ]
        );

        $this->command->info("✅ Usuário gerente criado:");
        $this->command->info("   Email: gerente@b2cstore.com");
        $this->command->info("   Senha: gerente123");
        $this->command->info("   ID: {$gerente->id_usuario}");
    }
}