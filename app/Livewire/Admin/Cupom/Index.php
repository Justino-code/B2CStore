<?php

namespace App\Livewire\Admin\Cupom;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cupom;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $tipo = 'todos'; // todos, percentual, fixo
    public $status = 'ativos'; // ativos, expirados, inativos
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedItems = [];
    public $selectAll = false;

    protected $queryString = [
        'tipo' => ['except' => 'todos'],
        'status' => ['except' => 'ativos'],
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = $this->cupons->pluck('id_cupom')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function toggleStatus($id)
    {
        $cupom = Cupom::find($id);
        if ($cupom) {
            $cupom->ativo = !$cupom->ativo;
            $cupom->save();
            $this->dispatch('notify', 
                type: 'success',
                message: 'Status do cupom atualizado!'
            );
        }
    }

    #[On('deletarSelecionadosConfirmado')]
    public function deletarSelecionadosConfirmado()
    {
        if (empty($this->selectedItems)) {
            $this->dispatch('notify', 
                type: 'warning',
                message: 'Selecione pelo menos um cupom para deletar.'
            );
            return;
        }

        $deleted = Cupom::whereIn('id_cupom', $this->selectedItems)->delete();

        $this->selectedItems = [];
        $this->selectAll = false;
        
        $this->dispatch('notify', 
            type: 'success',
            message: $deleted . ' cupom(ns) deletado(s) com sucesso!'
        );
    }

    public function duplicarCupom($id)
    {
        $cupomOriginal = Cupom::findOrFail($id);
        
        $novoCupom = $cupomOriginal->replicate();
        $novoCupom->codigo = $this->gerarCodigoUnico($cupomOriginal->codigo);
        $novoCupom->usos_atual = 0;
        $novoCupom->created_at = now();
        $novoCupom->updated_at = now();
        $novoCupom->save();

        $this->dispatch('notify', 
            type: 'success',
            message: 'Cupom duplicado com sucesso! Novo código: ' . $novoCupom->codigo
        );
    }

    #[On('deleteCupomConfirmed')]
    public function deleteCupomConfirmed($id)
    {
        $cupom = Cupom::find($id);
        if ($cupom) {
            $cupom->delete();
            $this->dispatch('notify', 
                type: 'success',
                message: 'Cupom deletado com sucesso!'
            );
        }
    }

    private function gerarCodigoUnico($codigoBase)
    {
        $sufixo = 1;
        $novoCodigo = $codigoBase . '-' . $sufixo;
        
        while (Cupom::where('codigo', $novoCodigo)->exists()) {
            $sufixo++;
            $novoCodigo = $codigoBase . '-' . $sufixo;
        }
        
        return $novoCodigo;
    }

    public function getCuponsProperty()
    {
        return Cupom::query()
            ->when($this->tipo !== 'todos', function ($query) {
                $query->where('tipo_desconto', $this->tipo);
            })
            ->when($this->status !== 'todos', function ($query) {
                if ($this->status === 'ativos') {
                    $query->where('ativo', true)
                          ->where(function ($q) {
                              $q->whereNull('validade_fim')
                                ->orWhere('validade_fim', '>=', now());
                          });
                } elseif ($this->status === 'expirados') {
                    $query->where('ativo', true)
                          ->where('validade_fim', '<', now());
                } elseif ($this->status === 'inativos') {
                    $query->where('ativo', false);
                }
            })
            ->when($this->search, function ($query) {
                $query->where('codigo', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);
    }

    public function getEstatisticasProperty()
    {
        $totalCupons = Cupom::count();
        
        $cuponsAtivos = Cupom::where('ativo', true)
            ->where(function ($query) {
                $query->whereNull('validade_fim')
                      ->orWhere('validade_fim', '>=', now());
            })
            ->count();
        
        $totalUsos = Cupom::sum('usos_atual');
        
        $cuponsProximoExpirar = Cupom::where('ativo', true)
            ->whereNotNull('validade_fim')
            ->where('validade_fim', '>=', now())
            ->where('validade_fim', '<=', now()->addDays(7))
            ->count();

        return [
            'totalCupons' => $totalCupons,
            'cuponsAtivos' => $cuponsAtivos,
            'totalUsos' => $totalUsos,
            'cuponsProximoExpirar' => $cuponsProximoExpirar,
        ];
    }

    public function render()
    {
        return view('livewire.admin.cupom.index', [
            'cupons' => $this->cupons,
            'estatisticas' => $this->estatisticas,
        ]);
    }
}