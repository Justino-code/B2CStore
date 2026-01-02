<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrinho;
use App\Models\Pedido;
use App\Models\Pagamento;
use App\Services\PagamentoService;
use Illuminate\Support\Str;

use Livewire\Attributes\Layout;

#[Layout('components.layouts.cliente')]
class Checkout extends Component
{
    // Passo atual do checkout
    public $passo = 1; // 1: Endereços, 2: Pagamento, 3: Confirmação
    
    // Endereços
    public $usar_endereco_cadastrado = true;
    public $novo_endereco = [
        'rua' => '',
        'numero' => '',
        'bairro' => '',
        'municipio' => '',
        'provincia' => '',
        'complemento' => '',
        'referencia' => '',
    ];
    
    // Dados de pagamento
    public $metodo_pagamento = 'cartao_credito';
    public $parcelas = 1;
    public $numero_cartao;
    public $nome_cartao;
    public $validade_mes;
    public $validade_ano;
    public $cvv;
    
    // Observações
    public $observacoes;
    
    // Pedido atual
    public $pedido;
    
    // Status
    public $processando = false;
    public $erro;
    public $sucesso;
    public $pagamentoResultado;
    
    protected $pagamentoService;
    
    public function rules()
    {
        $anoAtual = date('Y');
        
        return [
            'novo_endereco.logradouro' => 'required_if:usar_endereco_cadastrado,false|string|max:255',
            'novo_endereco.numero' => 'required_if:usar_endereco_cadastrado,false|string|max:20',
            'novo_endereco.bairro' => 'required_if:usar_endereco_cadastrado,false|string|max:100',
            'novo_endereco.cidade' => 'required_if:usar_endereco_cadastrado,false|string|max:100',
            'novo_endereco.estado' => 'required_if:usar_endereco_cadastrado,false|string|max:2',
            'novo_endereco.cep' => 'required_if:usar_endereco_cadastrado,false|string|size:5',
            'observacoes' => 'nullable|string|max:500',
            'metodo_pagamento' => 'required|in:cartao_credito,boleto,transferencia',
            'parcelas' => 'required_if:metodo_pagamento,cartao_credito|integer|min:1|max:12',
            'numero_cartao' => 'required_if:metodo_pagamento,cartao_credito|string|size:16',
            'nome_cartao' => 'required_if:metodo_pagamento,cartao_credito|string|max:255',
            'validade_mes' => 'required_if:metodo_pagamento,cartao_credito|integer|between:1,12',
            'validade_ano' => 'required_if:metodo_pagamento,cartao_credito|integer|min:' . $anoAtual,
            'cvv' => 'required_if:metodo_pagamento,cartao_credito|string|size:3',
        ];
    }
    
    protected $messages = [
        'novo_endereco.numero.required_if' => 'O número é obrigatório.',
        'novo_endereco.bairro.required_if' => 'O bairro é obrigatório.',
        'novo_endereco.cidade.required_if' => 'A cidade é obrigatória.',
        'novo_endereco.estado.required_if' => 'O estado é obrigatório.',
        'novo_endereco.cep.required_if' => 'O CEP é obrigatório.',
        'numero_cartao.required_if' => 'O número do cartão é obrigatório.',
        'numero_cartao.size' => 'O número do cartão deve ter 16 dígitos.',
        'nome_cartao.required_if' => 'O nome no cartão é obrigatório.',
        'cvv.required_if' => 'O CVV é obrigatório.',
        'cvv.size' => 'O CVV deve ter 3 dígitos.',
    ];

    public function __construct(){
        $this->pagamentoService = app(PagamentoService::class);
    }
    
    public function mount()
    {
        
        // Verificar se há carrinho
        $carrinho = Carrinho::where('id_usuario', Auth::id())
            ->with('itens.produto')
            ->first();
        
        if (!$carrinho || $carrinho->itens->isEmpty()) {
            session()->flash('error', 'Seu carrinho está vazio.');
            return redirect()->route('cliente.carrinho');
        }
        
        // Preencher endereço do usuário se existir
        $usuario = Auth::user();
        if ($usuario->tem_endereco) {
            $this->novo_endereco = array_merge(
                $this->novo_endereco,
                $usuario->endereco_array
            );
        }
    }
    
    public function render()
    {
        $carrinho = Carrinho::where('id_usuario', Auth::id())
            ->with(['itens.produto.imagens'])
            ->first();
            
        $usuario = Auth::user();
        
        $metodos_pagamento = [
            'cartao_credito' => [
                'nome' => 'Cartão de Crédito',
                'icone' => 'credit-card',
                'parcelas' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                'taxa' => 0,
            ],
            'boleto' => [
                'nome' => 'Boleto Bancário',
                'icone' => 'barcode',
                'desconto' => 5,
                'vencimento' => 3,
            ],
            'transferencia' => [
                'nome' => 'Transferência Bancária',
                'icone' => 'bank',
                'desconto' => 3,
            ],
        ];
        
        return view('livewire.cliente.checkout', [
            'carrinho' => $carrinho,
            'usuario' => $usuario,
            'metodos_pagamento' => $metodos_pagamento,
        ]);
    }
    
    // Avançar para o passo de pagamento
    public function avancarParaPagamento()
    {
        // Se não usar endereço cadastrado, validar novo endereço
        if (!$this->usar_endereco_cadastrado) {
            $this->validate([
                'novo_endereco.logradouro' => 'required|string|max:255',
                'novo_endereco.numero' => 'required|string|max:20',
                'novo_endereco.bairro' => 'required|string|max:100',
                'novo_endereco.cidade' => 'required|string|max:100',
                'novo_endereco.estado' => 'required|string|max:2',
                'novo_endereco.cep' => 'required|string|size:5',
                'observacoes' => 'nullable|string|max:500',
            ]);
            
            // Atualizar endereço do usuário se ele quiser salvar
            if (Auth::user()->tem_endereco) {
                // Perguntar se quer atualizar? (podemos fazer com modal depois)
            }
        } else {
            // Validar apenas observações
            $this->validate([
                'observacoes' => 'nullable|string|max:500',
            ]);
            
            // Verificar se usuário tem endereço cadastrado
            if (!Auth::user()->tem_endereco) {
                $this->erro = 'Você precisa cadastrar um endereço antes de continuar.';
                return;
            }
        }
        
        // Criar pedido
        $this->criarPedido();
        
        // Avançar para passo 2
        $this->passo = 2;
    }
    
    // Voltar para o passo anterior
    public function voltarParaEnderecos()
    {
        $this->passo = 1;
    }
    
    // Processar pagamento
    public function rulesPagamento()
    {
        $anoAtual = date('Y');
        
        return [
            'metodo_pagamento' => 'required|in:cartao_credito,boleto,transferencia',
            'parcelas' => 'required_if:metodo_pagamento,cartao_credito|integer|min:1|max:12',
            'numero_cartao' => 'required_if:metodo_pagamento,cartao_credito|string|size:16',
            'nome_cartao' => 'required_if:metodo_pagamento,cartao_credito|string|max:255',
            'validade_mes' => 'required_if:metodo_pagamento,cartao_credito|integer|between:1,12',
            'validade_ano' => 'required_if:metodo_pagamento,cartao_credito|integer|min:' . $anoAtual,
            'cvv' => 'required_if:metodo_pagamento,cartao_credito|string|size:3',
        ];
    }

    public function processarPagamento()
    {
        $this->reset('erro', 'sucesso', 'pagamentoResultado');
        $this->processando = true;
        
        // Usar o método rulesPagamento
        $validated = $this->validate($this->rulesPagamento());
        
        try {
            $dadosPagamento = [
                'metodo' => $this->metodo_pagamento,
                'parcelas' => $this->parcelas,
                'numero_cartao' => $this->numero_cartao,
                'nome_cartao' => $this->nome_cartao,
                'validade_mes' => $this->validade_mes,
                'validade_ano' => $this->validade_ano,
                'cvv' => $this->cvv,
            ];
            
            $resultado = $this->pagamentoService->processarPagamento($this->pedido, $dadosPagamento);
            
            if ($resultado['sucesso']) {
                // Limpar carrinho
                Carrinho::where('id_usuario', Auth::id())->delete();
                
                $this->pagamentoResultado = $resultado;
                $this->sucesso = $resultado['mensagem'];
                $this->passo = 3; // Ir para confirmação
                
                // Emitir evento para atualizar outros componentes
                $this->dispatch('carrinho-atualizado');
            } else {
                $this->erro = $resultado['mensagem'];
            }
        } catch (\Exception $e) {
            $this->erro = 'Erro ao processar pagamento: ' . $e->getMessage();
        } finally {
            $this->processando = false;
        }
    }
    
    // Criar pedido
    private function criarPedido()
    {
        $carrinho = Carrinho::where('id_usuario', Auth::id())
            ->with('itens.produto')
            ->first();
        
        // Calcular totais
        $subtotal = $carrinho->itens->sum(function ($item) {
            return ($item->produto->preco_promocional ?? $item->produto->preco) * $item->quantidade;
        });
        
        // Preparar endereço para salvar no pedido
        $enderecoEntrega = '';

        if ($this->usar_endereco_cadastrado && Auth::user()->tem_endereco) {
            $enderecoArray = Auth::user()->endereco_array;
            $enderecoEntrega = implode(', ', [
                $enderecoArray['rua'],
                $enderecoArray['numero'],
                $enderecoArray['bairro'],
                $enderecoArray['municipio'],
                $enderecoArray['provincia'],
                $enderecoArray['complemento'],
                $enderecoArray['referencia'],
            ]);
        } else {
            $enderecoEntrega = implode(', ', [
                $this->novo_endereco['rua'],
                $this->novo_endereco['numero'],
                $this->novo_endereco['bairro'],
                $this->novo_endereco['municipio'],
                $this->novo_endereco['provincia'],
                $this->novo_endereco['complemento'],
                 $this->novo_endereco['referencia'],
            ]);
        }
        
        $this->pedido = Pedido::create([
            'id_usuario' => Auth::id(),
            'numero_pedido' => 'PED' . strtoupper(uniqid()),
            'status' => 'pendente',
            'subtotal' => $subtotal,
            'frete' => $carrinho->frete ?? 0,
            'desconto' => $carrinho->desconto ?? 0,
            'total' => $subtotal + ($carrinho->frete ?? 0) - ($carrinho->desconto ?? 0),
            'endereco_entrega' => $enderecoEntrega,
            'observacoes' => $this->observacoes,
            'cupom_aplicado' => $carrinho->cupom_aplicado,
            'id_cupom' => $carrinho->id_cupom,
        ]);
        
        // Criar itens do pedido
        foreach ($carrinho->itens as $item) {
            $this->pedido->itens()->create([
                'id_produto' => $item->id_produto,
                'quantidade' => $item->quantidade,
                'preco_unitario' => $item->produto->preco_promocional ?? $item->produto->preco,
                'total' => ($item->produto->preco_promocional ?? $item->produto->preco) * $item->quantidade,
            ]);
        }
    }
    
    // Formatar número do cartão
    public function formatarNumeroCartao()
    {
        if ($this->numero_cartao) {
            $this->numero_cartao = preg_replace('/\D/', '', $this->numero_cartao);
            $this->numero_cartao = substr($this->numero_cartao, 0, 16);
        }
    }
    
    // Formatar CVV
    public function formatarCvv()
    {
        if ($this->cvv) {
            $this->cvv = preg_replace('/\D/', '', $this->cvv);
            $this->cvv = substr($this->cvv, 0, 3);
        }
    }
    
    // Formatar CEP
    public function formatarCep()
    {
        if ($this->novo_endereco['cep']) {
            $this->novo_endereco['cep'] = preg_replace('/\D/', '', $this->novo_endereco['cep']);
            $this->novo_endereco['cep'] = substr($this->novo_endereco['cep'], 0, 5);
        }
    }
    
    // Calcular valor da parcela
    public function getValorParcelaProperty()
    {
        if (!$this->pedido || $this->metodo_pagamento !== 'cartao_credito') {
            return 0;
        }
        
        return $this->pedido->total / $this->parcelas;
    }
    
    // Calcular desconto
    public function getDescontoMetodoProperty()
    {
        $descontos = [
            'boleto' => 5,
            'transferencia' => 3,
            'cartao_credito' => 0,
        ];
        
        return $descontos[$this->metodo_pagamento] ?? 0;
    }
    
    // Calcular total com desconto
    public function getTotalComDescontoProperty()
    {
        if (!$this->pedido) {
            return 0;
        }
        
        $desconto = $this->pedido->total * ($this->desconto_metodo / 100);
        return $this->pedido->total - $desconto;
    }
}