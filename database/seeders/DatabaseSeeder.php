<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('🚀 Iniciando seeders do B2CStore...');
        $this->command->line('');

        // 1. Criar categorias PRIMEIRO (para que produtos possam referenciá-las)
        $this->command->info('📁 Criando categorias...');
        $this->call(CategoriaSeeder::class);
        $this->command->line('');

        $this->call(MarcaSeeder::class);
        $this->call(BannerSeeder::class);

        // 2. Criar administrador principal
        $this->command->info('👑 Criando administrador...');
        $this->call(AdminSeeder::class);
        $this->command->line('');

        // 3. Criar usuários
        $this->command->info('👥 Criando usuários...');
        $this->call(UsuarioSeeder::class);
        $this->command->line('');

        // 4. Criar produtos (depende de categorias)
        $this->command->info('🛍️  Criando produtos...');
        $this->call(ProdutoSeeder::class);
        $this->command->line('');

        // 5. Criar cupons
        $this->command->info('🎫 Criando cupons...');
        $this->call(CupomSeeder::class);
        $this->command->line('');

        // 6. Criar carrinhos (depende de usuários e produtos)
        $this->command->info('🛒 Criando carrinhos...');
        $this->call(CarrinhoSeeder::class);
        $this->command->line('');

        // 7. Criar pedidos (depende de usuários, produtos e cupons)
        $this->command->info('📦 Criando pedidos...');
        $this->call(PedidoSeeder::class);
        $this->command->line('');

        // 8. Criar reviews (depende de usuários e produtos)
        $this->command->info('⭐ Criando reviews...');
        $this->call(ReviewSeeder::class);
        $this->command->line('');

        // 9. Criar favoritos (depende de usuários e produtos)
        $this->command->info('❤️  Criando favoritos...');
        $this->call(FavoritoSeeder::class);
        $this->command->line('');

        $this->command->info('✅ Seeders concluídos com sucesso!');
        $this->command->line('');
        $this->command->info('🎯 Dados para acesso:');
        $this->command->info('   👑 Admin: admin@b2cstore.com / admin123');
        $this->command->info('   👤 Cliente: joao@email.com / senha123');
        $this->command->info('   👤 Cliente: maria@email.com / senha123');
        $this->command->line('');
        $this->command->info('🎫 Cupons disponíveis: ESCOLA10, VOLTAASULAS, PRIMEIRACOMPRA');
    }
}
