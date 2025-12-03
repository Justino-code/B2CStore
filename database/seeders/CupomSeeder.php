<?php

namespace Database\Seeders;

use App\Models\Cupom;
use Illuminate\Database\Seeder;

class CupomSeeder extends Seeder
{
    /**
     * Cupons padrão declarados fora da função run()
     */
    protected array $cuponsPadrao = [
        [
            'codigo' => 'ESCOLA10',
            'tipo_desconto' => 'percentual',
            'valor_desconto' => 10,
            'valor_minimo' => 50,
            'usos_maximos' => 100,
            'validade_inicio' => null,
            'validade_fim' => null,
            'ativo' => true,
        ],
        [
            'codigo' => 'VOLTAASULAS',
            'tipo_desconto' => 'percentual',
            'valor_desconto' => 15,
            'valor_minimo' => 100,
            'usos_maximos' => 50,
            'validade_inicio' => null,
            'validade_fim' => null,
            'ativo' => true,
        ],
        [
            'codigo' => 'PRIMEIRACOMPRA',
            'tipo_desconto' => 'fixo',
            'valor_desconto' => 20,
            'valor_minimo' => 30,
            'usos_maximos' => null,
            'validade_inicio' => null,
            'validade_fim' => null,
            'ativo' => true,
        ],
        [
            'codigo' => 'FRETE10',
            'tipo_desconto' => 'percentual',
            'valor_desconto' => 10,
            'valor_minimo' => 80,
            'usos_maximos' => 200,
            'validade_inicio' => null,
            'validade_fim' => null,
            'ativo' => true,
        ],
        [
            'codigo' => 'EXPIRED',
            'tipo_desconto' => 'percentual',
            'valor_desconto' => 25,
            'valor_minimo' => 50,
            'usos_maximos' => 10,
            'validade_inicio' => null,
            'validade_fim' => null,
            'ativo' => true,
        ],
    ];

    public function run()
    {
        $this->command->info('🎫 Criando cupons...');

        $cuponsCriados = 0;

        foreach ($this->cuponsPadrao as $cupomData) {

            // Inserir datas dinâmicas agora
            $cupomData['validade_inicio'] = now()->subDays(1);

            // Cada cupom recebe sua validade específica fora do array
            switch ($cupomData['codigo']) {
                case 'ESCOLA10':
                    $cupomData['validade_fim'] = now()->addMonths(3);
                    break;
                case 'VOLTAASULAS':
                    $cupomData['validade_fim'] = now()->addMonths(2);
                    break;
                case 'PRIMEIRACOMPRA':
                    $cupomData['validade_fim'] = now()->addYear();
                    break;
                case 'FRETE10':
                    $cupomData['validade_fim'] = now()->addMonths(6);
                    break;
                case 'EXPIRED':
                    $cupomData['validade_inicio'] = now()->subMonths(2);
                    $cupomData['validade_fim'] = now()->subDays(10);
                    break;
            }

            try {
                Cupom::firstOrCreate(
                    ['codigo' => $cupomData['codigo']],
                    $cupomData
                );
                $cuponsCriados++;
            } catch (\Exception $e) {
                $this->command->warn("⚠️ Erro ao criar cupom {$cupomData['codigo']}: " . $e->getMessage());
            }
        }

        $this->command->info("✅ {$cuponsCriados} cupons criados");
    }
}

