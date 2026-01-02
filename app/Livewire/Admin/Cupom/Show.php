<?php

namespace App\Livewire\Admin\Cupom;

use Livewire\Component;
use App\Models\Cupom;
use App\Models\Pedido;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin')]
class Show extends Component
{
    public $cupom;
    public $cupomId;
    public $pedidos = [];
    public $estatisticas = [];

    public function mount($id)
    {
        $this->cupomId = $id;
        $this->carregarCupom();
        $this->carregarEstatisticas();
    }

    public function carregarCupom()
    {
        $this->cupom = Cupom::findOrFail($this->cupomId);
    }

    public function carregarEstatisticas()
    {
        // Pedidos que usaram este cupom
        $this->pedidos = Pedido::where('id_cupom', $this->cupomId)
            ->with(['usuario'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Estatísticas
        $pedidosComCupom = Pedido::where('id_cupom', $this->cupomId)->get();
        
        $this->estatisticas = [
            'totalUsos' => $this->cupom->usos_atual,
            'totalPedidos' => $pedidosComCupom->count(),
            'valorTotalDescontado' => $pedidosComCupom->sum('valor_desconto'),
            'valorTotalVendas' => $pedidosComCupom->sum('total'),
            'taxaUtilizacao' => $this->cupom->usos_maximos ? 
                ($this->cupom->usos_atual / $this->cupom->usos_maximos * 100) : 0,
        ];
    }

    public function toggleStatus()
    {
        $this->cupom->ativo = !$this->cupom->ativo;
        $this->cupom->save();
        $this->carregarCupom();
        $this->dispatch('notify', 
            type: 'success',
            message: 'Status do cupom atualizado!'
        );
    }

    public function deletarCupom()
    {
        $this->dispatch('confirm', 
            title: 'Confirmar exclusão',
            text: 'Tem certeza que deseja deletar este cupom? Esta ação não pode ser desfeita.',
            confirmButtonText: 'Sim, deletar',
            cancelButtonText: 'Cancelar',
            method: 'deletar-cupom'
        );
    }

    #[On('deletar-cupom')]
    public function deletarCupomConfirmado()
    {
        try {
            $this->cupom->delete();
            $this->dispatch('notify', 
                type: 'success',
                message: 'Cupom deletado com sucesso!'
            );
            return redirect()->route('admin.cupons.index');
        } catch (\Exception $e) {
            $this->dispatch('notify', 
                type: 'error',
                message: 'Erro ao deletar cupom: ' . $e->getMessage()
            );
        }
    }

    #[Computed]
    public function statusLabel()
    {
        if (!$this->cupom->ativo) {
            return 'Inativo';
        }

        if (!$this->cupom->valido()) {
            return 'Inválido';
        }

        return 'Ativo';
    }

    #[Computed]
    public function statusColor()
    {
        $status = $this->statusLabel;
        
        return match($status) {
            'Ativo' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'Inativo' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            'Inválido' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
        };
    }

    public function render()
    {
        return view('livewire.admin.cupom.show');
    }
}