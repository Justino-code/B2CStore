<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrinho as ModelCarrinho;
use App\Models\CarrinhoItem;
use App\Models\Produto;
use App\Models\Cupom;

class Carrinho extends Component
{
    public $carrinho;
    public $itens = [];
    public $subtotal = 0;
    public $frete = 0;
    public $desconto = 0;
    public $total = 0;
    public $cupom = '';
    public $cupomAplicado = null;
    public $bairroFrete = '';
    public $calculandoFrete = false;
    public $erroCupom = '';
    
    // Modal para endereço
    public $mostrarModalEndereco = false;
    public $enderecoForm = [
        'bairro' => '',
        'municipio' => '',
        'provincia' => '',
        'rua' => '',
        'numero' => '',
        'complemento' => '',
        'referencia' => '',
    ];
    
    // Províncias de Angola
    public $provincias = [
        'Bengo', 'Benguela', 'Bié', 'Cabinda', 'Cuando Cubango',
        'Cuanza Norte', 'Cuanza Sul', 'Cunene', 'Huambo', 'Huíla',
        'Luanda', 'Lunda Norte', 'Lunda Sul', 'Malanje', 'Moxico',
        'Namibe', 'Uíge', 'Zaire'
    ];
    
    protected $listeners = [
        'atualizar-carrinho' => 'carregarCarrinho',
        'limpar-carrinho' => 'limparCarrinho',
    ];

    public function mount()
    {
        $this->carregarCarrinho();
        $this->carregarEnderecoUsuario();
    }

    public function carregarCarrinho()
    {
        $usuarioId = Auth::id();
        $this->carrinho = ModelCarrinho::with(['itens.produto.imagens'])
            ->where('id_usuario', $usuarioId)
            ->first();

        if ($this->carrinho) {
            $this->itens = $this->carrinho->itens;
            
            if ($this->carrinho->cupom_aplicado) {
                $this->cupomAplicado = json_decode($this->carrinho->cupom_aplicado, true);
            }
            
            $this->calcularTotais();
        } else {
            $this->carrinho = ModelCarrinho::create([
                'id_usuario' => $usuarioId,
                'subtotal' => 0,
                'frete' => 0,
                'desconto' => 0,
                'total' => 0,
            ]);
            $this->itens = collect([]);
        }
    }

    public function carregarEnderecoUsuario()
    {
        $usuario = Auth::user();
        if ($usuario && $usuario->endereco) {
            $enderecoArray = $usuario->endereco_array;
            $this->enderecoForm = array_merge($this->enderecoForm, $enderecoArray);
        }
    }

    public function calcularTotais()
    {
        $this->subtotal = 0;
        
        foreach ($this->itens as $item) {
            $preco = $item->produto->preco_promocional ?? $item->produto->preco;
            $this->subtotal += $preco * $item->quantidade;
        }

        // Calcular frete baseado no bairro
        $this->frete = $this->calcularFretePorBairro($this->bairroFrete);
        
        // Frete grátis se valor acima de 50000 Kz
        if ($this->subtotal > 50000) {
            $this->frete = 0;
        }
        
        $descontoCupom = 0;
        if ($this->cupomAplicado) {
            if ($this->cupomAplicado['tipo_desconto'] == 'percentual') {
                $descontoCupom = ($this->subtotal * $this->cupomAplicado['valor_desconto']) / 100;
            } else {
                $descontoCupom = $this->cupomAplicado['valor_desconto'];
            }
        }
        
        $this->desconto = $descontoCupom;
        $this->total = max(0, $this->subtotal + $this->frete - $this->desconto);
        
        if ($this->carrinho) {
            $this->carrinho->update([
                'subtotal' => $this->subtotal,
                'frete' => $this->frete,
                'desconto' => $this->desconto,
                'total' => $this->total,
            ]);
        }
    }

    private function calcularFretePorBairro($bairro)
    {
        if (empty($bairro)) {
            return 1500; // Valor padrão em Kz
        }
        
        // Exemplo de valores por zona/bairro em Luanda (em Kz)
        $zonas = [
            'centro' => ['maianga', 'ingombota', 'baixa', 'maculusso', 'kinaxixi'],
            'sul' => ['talatona', 'cacuaco', 'kilamba', 'camama', 'benfica'],
            'norte' => ['cazenga', 'viana', 'sambizanga', 'ngola kiluanje'],
        ];
        
        $bairroLower = strtolower($bairro);
        
        foreach ($zonas['centro'] as $bairroCentro) {
            if (str_contains($bairroLower, $bairroCentro)) {
                return 1000; // Frete mais barato para centro
            }
        }
        
        foreach ($zonas['sul'] as $bairroSul) {
            if (str_contains($bairroLower, $bairroSul)) {
                return 1500; // Frete médio para zona sul
            }
        }
        
        return 2000; // Frete mais caro para outras zonas
    }

    public function atualizarQuantidade($itemId, $quantidade)
    {
        if ($quantidade < 1) {
            $this->removerItem($itemId);
            return;
        }

        $item = CarrinhoItem::find($itemId);
        if ($item && $item->carrinho->id_usuario == Auth::id()) {
            // Verificar estoque
            $produto = Produto::find($item->id_produto);
            if ($quantidade > $produto->estoque) {
                $this->dispatch('notify',
                    type: 'error',
                    message: 'Quantidade indisponível em estoque.'
                );
                return;
            }

            $item->quantidade = $quantidade;
            $item->save();
            $this->carregarCarrinho();
            
            $this->dispatch('notify',
                type: 'success',
                message: 'Quantidade atualizada!'
            );
            
            $this->dispatch('carrinho-atualizado');
        }
    }

    public function removerItem($itemId)
    {
        $item = CarrinhoItem::find($itemId);
        if ($item && $item->carrinho->id_usuario == Auth::id()) {
            $nomeProduto = $item->produto->nome;
            $item->delete();
            $this->carregarCarrinho();
            
            $this->dispatch('notify',
                type: 'success',
                message: '"' . $nomeProduto . '" removido do carrinho!'
            );
            
            $this->dispatch('carrinho-atualizado');
        }
    }

    public function aplicarCupom()
    {
        $this->validate([
            'cupom' => 'required|string|max:50'
        ]);

        // Validar cupom no banco de dados
        $cupom = Cupom::where('codigo', strtoupper($this->cupom))
            ->where('ativo', true)
            ->where(function($query) {
                $query->whereNull('validade')
                      ->orWhere('validade', '>=', now());
            })
            ->first();
        
        if ($cupom) {
            // Verificar se já foi usado pelo usuário
            if ($cupom->limite_usos && $cupom->usos >= $cupom->limite_usos) {
                $this->erroCupom = 'Este cupom atingiu o limite de usos.';
                $this->dispatch('notify',
                    type: 'error',
                    message: $this->erroCupom
                );
                return;
            }
            
            // Verificar valor mínimo
            if ($cupom->valor_minimo && $this->subtotal < $cupom->valor_minimo) {
                $this->erroCupom = 'Valor mínimo para usar este cupom: ' . format_kwanza($cupom->valor_minimo);
                $this->dispatch('notify',
                    type: 'error',
                    message:  $this->erroCupom
                );
                return;
            }
            
            $this->cupomAplicado = [
                'codigo' => $cupom->codigo,
                'tipo_desconto' => $cupom->tipo_desconto,
                'valor_desconto' => $cupom->valor_desconto,
                'id_cupom' => $cupom->id_cupom,
            ];
            
            // Salvar no carrinho
            $this->carrinho->update([
                'cupom_aplicado' => json_encode($this->cupomAplicado),
                'id_cupom' => $cupom->id_cupom,
            ]);
            
            $this->calcularTotais();
            
            $this->dispatch('notify',
                type: 'success',
                message: 'Cupom aplicado com success!'
            );
        } else {
            $this->erroCupom = 'Cupom inválido ou expirado.';
            $this->dispatch('notify',
                type: 'error',
                message: $this->erroCupom
            );
        }
    }

    public function removerCupom()
    {
        $this->cupom = '';
        $this->cupomAplicado = null;
        
        $this->carrinho->update([
            'cupom_aplicado' => null,
            'id_cupom' => null,
        ]);
        
        $this->calcularTotais();
        
        $this->dispatch('notify',
            type: 'info',
            message: 'Cupom removido.'
        );
    }

    public function calcularFrete()
    {
        $this->validate([
            'bairroFrete' => 'required|string|min:3|max:100'
        ]);
        
        $this->calculandoFrete = true;
        
        // Calcular frete baseado no bairro
        $freteCalculado = $this->calcularFretePorBairro($this->bairroFrete);
        
        // Aplicar frete grátis se valor acima de 50000 Kz
        if ($this->subtotal > 50000) {
            $freteCalculado = 0;
        }
        
        $this->frete = $freteCalculado;
        $this->calculandoFrete = false;
        
        $this->carrinho->update(['frete' => $this->frete]);
        $this->calcularTotais();
        
        $this->dispatch('notify', 
            type: 'success',
            message: 'Frete calculado com success!'
        );
    }

    public function limparCarrinho()
    {
        if ($this->carrinho) {
            $this->carrinho->itens()->delete();
            
            $this->carrinho->update([
                'subtotal' => 0,
                'frete' => 0,
                'desconto' => 0,
                'total' => 0,
                'cupom_aplicado' => null,
                'id_cupom' => null,
            ]);
            
            $this->carregarCarrinho();
            
            $this->dispatch('notify',
                type: 'info',
                message: 'Carrinho limpo com success!'
            );
        }
    }

    public function finalizarCompra()
    {
        // Verificar se há itens no carrinho
        if ($this->itens->isEmpty()) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Seu carrinho está vazio!'
            );
            return;
        }

        // Verificar estoque de todos os itens
        foreach ($this->itens as $item) {
            if ($item->quantidade > $item->produto->estoque) {
                $this->dispatch('notify',
                    type: 'error',
                    message: 'O produto "' . $item->produto->nome . '" não tem estoque suficiente.'
                );
                return;
            }
        }

        // Verificar se o usuário tem endereço cadastrado
        $usuario = Auth::user();
        if (!$usuario->tem_endereco) {
            $this->mostrarModalEndereco = true;
            return;
        }

        // Redirecionar para checkout
        return redirect()->route('cliente.checkout');
    }

    public function salvarEndereco()
    {
        $this->validate([
            'enderecoForm.bairro' => 'required|string|max:100',
            'enderecoForm.municipio' => 'required|string|max:100',
            'enderecoForm.provincia' => 'required|string|in:' . implode(',', $this->provincias),
            'enderecoForm.rua' => 'required|string|max:255',
            'enderecoForm.numero' => 'required|string|max:20',
        ]);

        $usuario = Auth::user();
        
        // Criar string de endereço no formato: "Rua, Número, Bairro, Município, Província"
        $enderecoString = implode(', ', [
            $this->enderecoForm['rua'],
            $this->enderecoForm['numero'],
            $this->enderecoForm['bairro'],
            $this->enderecoForm['municipio'],
            $this->enderecoForm['provincia'],
        ]);

        // Adicionar complemento se existir
        if (!empty($this->enderecoForm['complemento'])) {
            $enderecoString .= ', ' . $this->enderecoForm['complemento'];
        }

        // Adicionar referência se existir
        if (!empty($this->enderecoForm['referencia'])) {
            $enderecoString .= ', ' . $this->enderecoForm['referencia'];
        }

        $usuario->update(['endereco' => $enderecoString]);
        
        $this->mostrarModalEndereco = false;
        
        $this->dispatch('notify',
            type: 'success',
            message: 'Endereço cadastrado com success!'
        );
        
        // Após salvar o endereço, redirecionar para checkout
        return redirect()->route('cliente.checkout');
    }

    public function continuarComprando()
    {
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.cliente.carrinho')
            ->layout('components.layouts.cliente', [
                'titulo' => 'Carrinho de Compras - B2CStore'
            ]);
    }
}