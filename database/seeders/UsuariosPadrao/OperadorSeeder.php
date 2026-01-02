<?php

namespace Database\Seeders\UsuariosPadrao;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OperadorSeeder extends Seeder
{
    public function run()
    {
        $operador = Usuario::firstOrCreate(
            ['email' => 'operador@b2cstore.com'],
            [
                'nome' => 'Operador de Logística',
                'senha' => Hash::make('operador123'),
                'telefone' => '(11) 97777-7777',
                'endereco' => 'R. Consolação, 500 - São Paulo/SP',
                'avatar_url' => 'https://ui-avatars.com/api/?name=Operador+B2C&background=F59E0B&color=fff',
                'role' => 'operador',
                'email_verificado_em' => now(),
            ]
        );

        $this->command->info("✅ Usuário operador criado:");
        $this->command->info("   Email: operador@b2cstore.com");
        $this->command->info("   Senha: operador123");
        $this->command->info("   ID: {$operador->id_usuario}");
    }
}