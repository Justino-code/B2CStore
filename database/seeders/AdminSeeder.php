<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admin = Usuario::firstOrCreate(
            ['email' => 'admin@b2cstore.com'],
            [
                'nome' => 'Administrador B2CStore',
                'senha' => Hash::make('admin123'),
                'telefone' => '(11) 99999-9999',
                'endereco' => 'Av. Paulista, 1000 - São Paulo/SP',
                'avatar_url' => 'https://ui-avatars.com/api/?name=Admin+B2C&background=1D4ED8&color=fff',
                'role' => 'admin',
                'email_verificado_em' => now(),
            ]
        );

        $this->command->info("✅ Usuário administrador criado:");
        $this->command->info("   Email: admin@b2cstore.com");
        $this->command->info("   Senha: admin123");
        $this->command->info("   ID: {$admin->id_usuario}");
    }
}
