<?php

namespace App\Services;

use App\Models\Pagamento;
use App\Models\Pedido;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PagamentoService
{
    // Tipos de falhas simuladas
    private $falhas = [
        [
            'codigo' => '51',
            'mensagem' => 'Saldo insuficiente',
            'detalhe' => 'Transação não autorizada. Saldo insuficiente.',
        ],
        [
            'codigo' => '57',
            'mensagem' => 'Transação não permitida',
            'detalhe' => 'Cartão não habilitado para este tipo de transação.',
        ],
        [
            'codigo' => '78',
            'mensagem' => 'Cartão bloqueado',
            'detalhe' => 'Cartão bloqueado por segurança.',
        ],
        [
            'codigo' => '05',
            'mensagem' => 'Não autorizada',
            'detalhe' => 'Transação não autorizada pela instituição emissora.',
        ],
        [
            'codigo' => '14',
            'mensagem' => 'Cartão inválido',
            'detalhe' => 'Número do cartão inválido.',
        ],
        [
            'codigo' => '54',
            'mensagem' => 'Cartão vencido',
            'detalhe' => 'Cartão com data de validade expirada.',
        ],
    ];

    // Bandeiras de cartão
    private $bandeiras = ['VISA', 'MASTERCARD', 'ELO', 'AMEX', 'HIPERCARD'];

    public function processarPagamento(Pedido $pedido, array $dadosPagamento)
    {
        try {
            // Validar dados básicos do cartão (se for cartão)
            if ($dadosPagamento['metodo'] === 'cartao_credito') {
                $validacao = $this->validarCartao($dadosPagamento);
                $dadosPagamento['metodo'] = 'cartao';
                if (!$validacao['valido']) {
                    return [
                        'sucesso' => false,
                        'mensagem' => $validacao['mensagem'],
                    ];
                }
            }

            // Criar registro de pagamento
            $pagamento = Pagamento::create([
                'id_pedido' => $pedido->id_pedido,
                'metodo' => $dadosPagamento['metodo'],
                'status' => 'pago',
                'valor' => $pedido->total,
                'transacao_id' => 'SIM_' . Str::random(20),
                'detalhes' => [
                    'dados_pagamento' => $this->mascararDadosPagamento($dadosPagamento),
                    'simulacao' => true,
                    'timestamp' => now()->toIso8601String(),
                ],
            ]);

            // Simular tempo de processamento (1-3 segundos)
            usleep(rand(1000000, 3000000));

            // Decidir resultado baseado em probabilidade
            $resultado = $this->simularResultado($dadosPagamento['metodo']);
            
            // Aplicar desconto baseado no método
            $valorComDesconto = $this->aplicarDesconto($pedido->total, $dadosPagamento['metodo']);
            
            if ($resultado['status'] === 'pago') {
                return $this->processarSucesso($pagamento, $pedido, $dadosPagamento, $valorComDesconto);
            } elseif ($resultado['status'] === 'pendente') {
                return $this->processarPendente($pagamento, $pedido, $dadosPagamento, $valorComDesconto);
            } else {
                return $this->processarFalha($pagamento, $pedido, $dadosPagamento);
            }
            
        } catch (\Exception $e) {
            Log::error('Erro ao processar pagamento: ' . $e->getMessage());

            dd($e);
            
            return [
                'sucesso' => false,
                'mensagem' => 'Erro interno ao processar pagamento. Tente novamente.',
            ];
        }
    }

    private function validarCartao(array $dados)
    {
        // Validar número do cartão (formato básico)
        if (strlen($dados['numero_cartao']) !== 16 || !is_numeric($dados['numero_cartao'])) {
            return [
                'valido' => false,
                'mensagem' => 'Número do cartão inválido.',
            ];
        }

        // Validar CVV
        if (strlen($dados['cvv']) !== 3 || !is_numeric($dados['cvv'])) {
            return [
                'valido' => false,
                'mensagem' => 'CVV inválido.',
            ];
        }

        // Validar validade
        $anoAtual = (int) date('Y');
        $mesAtual = (int) date('m');
        
        if ((int) $dados['validade_ano'] < $anoAtual) {
            return [
                'valido' => false,
                'mensagem' => 'Cartão vencido.',
            ];
        }
        
        if ((int) $dados['validade_ano'] == $anoAtual && (int) $dados['validade_mes'] < $mesAtual) {
            return [
                'valido' => false,
                'mensagem' => 'Cartão vencido.',
            ];
        }

        return ['valido' => true];
    }

    private function simularResultado($metodo)
    {
        $probabilidade = rand(1, 100);
        
        if ($metodo === 'boleto') {
            // Boleto sempre fica pendente para simular geração
            return ['status' => 'pendente', 'tipo' => 'boleto'];
        }
        
        if ($metodo === 'transferencia') {
            // Transferência tem maior chance de sucesso
            if ($probabilidade <= 90) {
                return ['status' => 'pago', 'tipo' => 'sucesso'];
            } elseif ($probabilidade <= 95) {
                return ['status' => 'pendente', 'tipo' => 'transferencia'];
            } else {
                return ['status' => 'falhou', 'tipo' => 'falha'];
            }
        }
        
        // Cartão de crédito
        if ($probabilidade <= 75) {
            return ['status' => 'pago', 'tipo' => 'sucesso'];
        } elseif ($probabilidade <= 85) {
            return ['status' => 'falhou', 'tipo' => 'falha'];
        } else {
            return ['status' => 'pendente', 'tipo' => 'analise'];
        }
    }

    private function aplicarDesconto($valor, $metodo)
    {
        $descontos = [
            'boleto' => 0.05, // 5%
            'transferencia' => 0.03, // 3%
            'cartao_credito' => 0.00,
        ];
        
        return $valor * (1 - ($descontos[$metodo] ?? 0));
    }

    private function processarSucesso($pagamento, $pedido, $dados, $valorComDesconto)
    {
        $bandeira = $this->bandeiras[rand(0, count($this->bandeiras) - 1)];
        $nsu = rand(100000000, 999999999);
        
        $pagamento->update([
            'status' => 'pago',
            'valor' => $valorComDesconto,
            'data_processamento' => now(),
            'detalhes' => array_merge($pagamento->detalhes, [
                'codigo_autorizacao' => 'AUT' . Str::random(6),
                'nsu' => $nsu,
                'mensagem' => 'Pagamento aprovado com sucesso',
                'bandeira' => $bandeira,
                'parcelas' => $dados['parcelas'] ?? 1,
                'valor_parcela' => $valorComDesconto / ($dados['parcelas'] ?? 1),
                'valor_original' => $pedido->total,
                'desconto_aplicado' => $pedido->total - $valorComDesconto,
            ]),
        ]);
        
        $pedido->update([
            'status' => 'pago',
            'total' => $valorComDesconto,
        ]);
        
        return [
            'sucesso' => true,
            'pagamento' => $pagamento,
            'mensagem' => 'Pagamento aprovado com sucesso! Seu pedido está sendo processado.',
        ];
    }

    private function processarPendente($pagamento, $pedido, $dados, $valorComDesconto)
    {
        $detalhes = $pagamento->detalhes;
        
        if ($dados['metodo'] === 'boleto') {
            $detalhes = array_merge($detalhes, [
                'codigo_boleto' => $this->gerarCodigoBoleto(),
                'linha_digitavel' => $this->gerarLinhaDigitavel(),
                'vencimento' => now()->addDays(3)->format('d/m/Y'),
                'valor' => $valorComDesconto,
                'instrucoes' => 'Pague até a data de vencimento para confirmar seu pedido.',
            ]);
        } else {
            $detalhes = array_merge($detalhes, [
                'status' => 'em_analise',
                'mensagem' => 'Pagamento em análise. Aguarde a confirmação.',
                'prazo_analise' => '1-2 dias úteis',
            ]);
        }
        
        $pagamento->update([
            'status' => 'pendente',
            'valor' => $valorComDesconto,
            'detalhes' => $detalhes,
        ]);
        
        $pedido->update([
            'status' => 'aguardando_pagamento',
            'total' => $valorComDesconto,
        ]);
        
        $mensagem = $dados['metodo'] === 'boleto' 
            ? 'Boleto gerado com sucesso! O pedido será processado após a confirmação do pagamento.'
            : 'Pagamento em análise. Você receberá uma confirmação em breve.';
        
        return [
            'sucesso' => true,
            'pagamento' => $pagamento,
            'pendente' => true,
            'mensagem' => $mensagem,
        ];
    }

    private function processarFalha($pagamento, $pedido, $dados)
    {
        $falha = $this->falhas[rand(0, count($this->falhas) - 1)];
        
        $pagamento->update([
            'status' => 'falhou',
            'detalhes' => array_merge($pagamento->detalhes, [
                'erro' => $falha,
                'mensagem' => 'Pagamento recusado',
                'sugestao' => 'Verifique os dados do cartão ou tente outro método de pagamento.',
            ]),
        ]);
        
        $pedido->update(['status' => 'pagamento_falhou']);
        
        return [
            'sucesso' => false,
            'pagamento' => $pagamento,
            'mensagem' => $falha['detalhe'],
        ];
    }

    private function gerarCodigoBoleto()
    {
        // Simula código de barras no formato: 00190.00009 00000.000000 00000.000000 1 00000000000000
        $codigo = '001' . rand(10, 99); // Banco
        $codigo .= '9' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT); // Moeda + fator vencimento
        $codigo .= str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT); // Valor nominal
        $codigo .= '00000000000'; // Campo livre
        $codigo .= '00000000000'; // Campo livre
        $codigo .= '00000000000'; // Campo livre
        
        // Adicionar dígitos verificadores (simplificado)
        $codigo .= rand(0, 9);
        $codigo .= rand(0, 9);
        
        // Formatar no padrão de boleto
        return implode('.', [
            substr($codigo, 0, 5),
            substr($codigo, 5, 5),
            substr($codigo, 10, 5),
            substr($codigo, 15, 6),
            substr($codigo, 21, 5),
            substr($codigo, 26, 6),
            substr($codigo, 32, 1),
            substr($codigo, 33, 14),
        ]);
    }

    private function gerarLinhaDigitavel()
    {
        $linha = '';
        for ($i = 0; $i < 47; $i++) {
            if ($i > 0 && $i % 5 == 0) {
                $linha .= '.';
            }
            $linha .= rand(0, 9);
        }
        return $linha;
    }

    private function mascararDadosPagamento(array $dados)
    {
        $dadosMascarados = $dados;
        
        if (isset($dados['numero_cartao'])) {
            $dadosMascarados['numero_cartao'] = '**** **** **** ' . substr($dados['numero_cartao'], -4);
        }
        
        if (isset($dados['cvv'])) {
            $dadosMascarados['cvv'] = '***';
        }
        
        return $dadosMascarados;
    }
}