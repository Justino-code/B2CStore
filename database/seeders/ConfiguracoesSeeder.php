<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracao;

class ConfiguracoesSeeder extends Seeder
{
    public function run(): void
    {
        $configuracoes = [
            // Sistema
            [
                'chave' => 'versao_sistema',
                'valor' => '1.0.0',
                'tipo' => 'string',
                'grupo' => 'sistema',
                'descricao' => 'Versão atual do sistema',
                'editavel' => false,
            ],
            [
                'chave' => 'nome_sistema',
                'valor' => 'B2CStore',
                'tipo' => 'string',
                'grupo' => 'sistema',
                'descricao' => 'Nome do sistema',
                'editavel' => true,
            ],
            [
                'chave' => 'manutencao',
                'valor' => '0',
                'tipo' => 'boolean',
                'grupo' => 'sistema',
                'descricao' => 'Modo de manutenção',
                'editavel' => true,
            ],
            
            // Segurança
            [
                'chave' => 'limite_tentativas_login',
                'valor' => '5',
                'tipo' => 'integer',
                'grupo' => 'seguranca',
                'descricao' => 'Número máximo de tentativas de login',
                'editavel' => true,
            ],
            [
                'chave' => 'tempo_bloqueio_login',
                'valor' => '15',
                'tipo' => 'integer',
                'grupo' => 'seguranca',
                'descricao' => 'Tempo de bloqueio em minutos após falhas',
                'editavel' => true,
            ],
            
            // Email
            [
                'chave' => 'email_suporte',
                'valor' => 'suporte@b2cstore.com',
                'tipo' => 'string',
                'grupo' => 'email',
                'descricao' => 'Email para suporte',
                'editavel' => true,
            ],
            [
                'chave' => 'email_vendas',
                'valor' => 'vendas@b2cstore.com',
                'tipo' => 'string',
                'grupo' => 'email',
                'descricao' => 'Email para vendas',
                'editavel' => true,
            ],
            
            // Loja
            [
                'chave' => 'frete_gratis_valor',
                'valor' => '150.00',
                'tipo' => 'float',
                'grupo' => 'loja',
                'descricao' => 'Valor mínimo para frete grátis',
                'editavel' => true,
            ],
            [
                'chave' => 'prazo_entrega_padrao',
                'valor' => '7',
                'tipo' => 'integer',
                'grupo' => 'loja',
                'descricao' => 'Prazo de entrega padrão em dias',
                'editavel' => true,
            ],
        ];

        foreach ($configuracoes as $config) {
            Configuracao::updateOrCreate(
                ['chave' => $config['chave']],
                $config
            );
        }
    }
}