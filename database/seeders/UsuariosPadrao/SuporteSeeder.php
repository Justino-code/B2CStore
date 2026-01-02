<?php

namespace Database\Seeders\UsuariosPadrao;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuporteSeeder extends Seeder
{
    public function run()
    {
        $suporte = Usuario::firstOrCreate(
            ['email' => 'suporte@b2cstore.com'],
            [
                'nome' => 'Atendente de Suporte',
                'senha' => Hash::make('suporte123'),
                'telefone' => '(11) 96666-6666',
                'endereco' => 'Av. Brigadeiro Faria Lima, 2000 - São Paulo/SP',
                'avatar_url' => 'https://ui-avatars.com/api/?name=Suporte+B2C&background=EF4444&color=fff',
                'role' => 'suporte',
                'email_verificado_em' => now(),
            ]
        );

        $this->command->info("✅ Usuário suporte criado:");
        $this->command->info("   Email: suporte@b2cstore.com");
        $this->command->info("   Senha: suporte123");
        $this->command->info("   ID: {$suporte->id_usuario}");
    }
}