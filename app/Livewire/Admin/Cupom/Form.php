<?php

namespace App\Livewire\Admin\Cupom;

use Livewire\Component;
use App\Models\Cupom;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Form extends Component
{
    public $cupom;
    public $cupomId;
    
    // Dados do cupom
    public $codigo;
    public $tipo_desconto = 'percentual';
    public $valor_desconto;
    public $valor_minimo;
    public $usos_maximos;
    public $validade_inicio;
    public $validade_fim;
    public $ativo = true;
    
    // UI State
    public $isEditing = false;

    public function mount($id = null)
    {
        $this->isEditing = !is_null($id);
        
        if ($this->isEditing) {
            $this->cupomId = $id;
            $this->carregarCupom();
        } else {
            $this->gerarCodigo();
            $this->validade_inicio = now()->format('Y-m-d');
            $this->validade_fim = now()->addMonth()->format('Y-m-d');
        }
    }

    protected function rules()
    {
        $rules = [
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('cupons', 'codigo')->ignore($this->cupomId, 'id_cupom')
            ],
            'tipo_desconto' => 'required|in:percentual,fixo',
            'valor_desconto' => 'required|numeric|min:0.01',
            'valor_minimo' => 'nullable|numeric|min:0',
            'usos_maximos' => 'nullable|integer|min:1',
            'validade_inicio' => 'nullable|date',
            'validade_fim' => 'nullable|date|after_or_equal:validade_inicio',
            'ativo' => 'boolean',
        ];

        // Validação específica para percentual
        if ($this->tipo_desconto === 'percentual') {
            $rules['valor_desconto'] = 'required|numeric|min:1|max:100';
        }

        return $rules;
    }

    public function carregarCupom()
    {
        $this->cupom = Cupom::findOrFail($this->cupomId);
        
        $this->codigo = $this->cupom->codigo;
        $this->tipo_desconto = $this->cupom->tipo_desconto;
        $this->valor_desconto = (float) $this->cupom->valor_desconto;
        $this->valor_minimo = $this->cupom->valor_minimo ? (float) $this->cupom->valor_minimo : null;
        $this->usos_maximos = $this->cupom->usos_maximos;
        $this->validade_inicio = $this->cupom->validade_inicio ? $this->cupom->validade_inicio->format('Y-m-d') : null;
        $this->validade_fim = $this->cupom->validade_fim ? $this->cupom->validade_fim->format('Y-m-d') : null;
        $this->ativo = $this->cupom->ativo;
    }

    public function gerarCodigo()
    {
        if (empty($this->codigo)) {
            $prefix = strtoupper(Str::random(3));
            $number = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            $this->codigo = "CUPOM{$prefix}{$number}";
            
            // Usar notificação ao invés de session flash
            $this->dispatch('notify', 
                type: 'info',
                message: 'Código do cupom gerado automaticamente!'
            );
        }
    }

    public function updatedTipoDesconto($value)
    {
        if ($value === 'percentual' && $this->valor_desconto > 100) {
            $this->valor_desconto = 100;
            
            $this->dispatch('notify', 
                type: 'warning',
                message: 'Valor ajustado para o máximo de 100%'
            );
        }
    }

    public function calcularValorFinal($preco)
    {
        if ($this->tipo_desconto === 'percentual') {
            $desconto = $preco * ($this->valor_desconto / 100);
        } else {
            $desconto = $this->valor_desconto;
        }
        
        // Aplica valor mínimo se existir
        if ($this->valor_minimo && $preco < $this->valor_minimo) {
            return $preco; // Não aplica desconto se valor for menor que mínimo
        }
        
        return max(0, $preco - $desconto);
    }

    public function salvar()
    {
        $this->validate();

        try {
            \DB::beginTransaction();

            if ($this->isEditing) {
                $cupom = $this->cupom;
            } else {
                $cupom = new Cupom();
                $cupom->usos_atual = 0;
            }

            $cupom->fill([
                'codigo' => strtoupper($this->codigo),
                'tipo_desconto' => $this->tipo_desconto,
                'valor_desconto' => $this->valor_desconto,
                'valor_minimo' => $this->valor_minimo ?: null,
                'usos_maximos' => $this->usos_maximos ?: null,
                'validade_inicio' => $this->validade_inicio ?: null,
                'validade_fim' => $this->validade_fim ?: null,
                'ativo' => $this->ativo,
            ]);

            $cupom->save();

            \DB::commit();

            $this->dispatch('notify', 
                type: 'success',
                message: $this->isEditing 
                    ? 'Cupom atualizado com sucesso!' 
                    : 'Cupom criado com sucesso!'
            );

            return redirect()->route('admin.cupons.show', $cupom->id_cupom);

        } catch (\Exception $e) {
            \DB::rollBack();
            
            $this->dispatch('notify', 
                type: 'error',
                message: 'Erro ao salvar cupom: ' . $e->getMessage()
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.cupom.form');
    }
}