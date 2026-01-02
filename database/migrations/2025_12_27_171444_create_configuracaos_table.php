<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracoes', function (Blueprint $table) {
            $table->id('id_configuracao');
            $table->string('chave')->unique();
            $table->text('valor')->nullable();
            $table->string('tipo')->default('string'); // string, integer, boolean, json
            $table->string('grupo')->default('geral'); // geral, sistema, email, pagamento, etc
            $table->text('descricao')->nullable();
            $table->boolean('editavel')->default(true);
            $table->timestamps();
        });

        // Inserir algumas configurações padrão
        DB::table('configuracoes')->insert([
            [
                'chave' => 'versao_sistema',
                'valor' => '1.0.0',
                'tipo' => 'string',
                'grupo' => 'sistema',
                'descricao' => 'Versão atual do sistema',
                'editavel' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chave' => 'nome_sistema',
                'valor' => 'B2CStore Admin',
                'tipo' => 'string',
                'grupo' => 'sistema',
                'descricao' => 'Nome do sistema',
                'editavel' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chave' => 'manutencao',
                'valor' => '0',
                'tipo' => 'boolean',
                'grupo' => 'sistema',
                'descricao' => 'Modo de manutenção ativado',
                'editavel' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chave' => 'limite_sessao_minutos',
                'valor' => '30',
                'tipo' => 'integer',
                'grupo' => 'seguranca',
                'descricao' => 'Tempo máximo de sessão em minutos',
                'editavel' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'chave' => 'email_suporte',
                'valor' => 'suporte@b2cstore.com',
                'tipo' => 'string',
                'grupo' => 'contato',
                'descricao' => 'Email para suporte',
                'editavel' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracoes');
    }
};