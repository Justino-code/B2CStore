<?php

namespace App\Livewire\Admin\Pedido;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pedido;
use App\Models\Usuario as User;
use Carbon\Carbon;

use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $clienteId = '';
    public $dataInicio = '';
    public $dataFim = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedPedidos = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'clienteId' => ['except' => ''],
        'dataInicio' => ['except' => ''],
        'dataFim' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount()
    {
        // Definir datas padrão (últimos 30 dias)
        $this->dataInicio = Carbon::now()->subDays(30)->format('Y-m-d');
        $this->dataFim = Carbon::now()->format('Y-m-d');
    }

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
            $this->selectedPedidos = $this->pedidos->pluck('id_pedido')->toArray();
        } else {
            $this->selectedPedidos = [];
        }
    }

    public function limparFiltros()
    {
        $this->search = '';
        $this->status = '';
        $this->clienteId = '';
        $this->dataInicio = Carbon::now()->subDays(30)->format('Y-m-d');
        $this->dataFim = Carbon::now()->format('Y-m-d');
        $this->selectedPedidos = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    public function atualizarStatusLote($status)
    {
        if (empty($this->selectedPedidos)) {
            session()->flash('warning', 'Selecione pelo menos um pedido para atualizar.');
            return;
        }

        $pedidos = Pedido::whereIn('id_pedido', $this->selectedPedidos)->get();
        
        foreach ($pedidos as $pedido) {
            if ($this->podeAtualizarStatus($pedido->status, $status)) {
                $pedido->update(['status' => $status]);
                
                // Aqui você pode adicionar lógica para enviar notificação ao cliente
                // e registrar histórico de status
            }
        }

        $this->selectedPedidos = [];
        $this->selectAll = false;
        
        session()->flash('success', count($pedidos) . ' pedidos atualizados para ' . $this->getStatusLabel($status) . '!');
    }

    public function exportarPedidos()
    {
        // Lógica para exportar pedidos selecionados
        $pedidos = Pedido::whereIn('id_pedido', $this->selectedPedidos)
            ->with(['usuario', 'itens.produto'])
            ->get();
        
        // Aqui você pode implementar a exportação para CSV, Excel, etc.
        session()->flash('info', 'Exportação iniciada para ' . count($pedidos) . ' pedidos.');
    }

    public function getPedidosProperty()
    {
        return Pedido::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('codigo_pedido', 'like', '%' . $this->search . '%')
                      ->orWhere('endereco_entrega', 'like', '%' . $this->search . '%')
                      ->orWhereHas('usuario', function ($q2) {
                          $q2->where('nome', 'like', '%' . $this->search . '%')
                             ->orWhere('email', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->clienteId, function ($query) {
                $query->where('id_usuario', $this->clienteId);
            })
            ->when($this->dataInicio && $this->dataFim, function ($query) {
                $query->whereBetween('created_at', [
                    Carbon::parse($this->dataInicio)->startOfDay(),
                    Carbon::parse($this->dataFim)->endOfDay()
                ]);
            })
            ->with(['usuario', 'pagamento', 'itens' => function($query) {
                $query->with('produto');
            }])
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);
    }

    public function getClientesProperty()
    {
        return User::where('role', 'cliente')
            ->orderBy('nome')
            ->get(['id_usuario', 'nome', 'email']);
    }

    private function podeAtualizarStatus($statusAtual, $novoStatus)
    {
        $transicoesPermitidas = [
            'pendente' => ['processando', 'cancelado'],
            'processando' => ['enviado', 'cancelado'],
            'enviado' => ['entregue'],
            'entregue' => [],
            'cancelado' => [],
        ];

        return in_array($novoStatus, $transicoesPermitidas[$statusAtual] ?? []);
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'pendente' => 'Pendente',
            'processando' => 'Em Processamento',
            'enviado' => 'Enviado',
            'entregue' => 'Entregue',
            'cancelado' => 'Cancelado',
        ];

        return $labels[$status] ?? $status;
    }

    public function render()
    {
        return view('livewire.admin.pedido.index', [
            'pedidos' => $this->pedidos,
            'clientes' => $this->clientes,
            'totalPedidos' => Pedido::count(),
            'totalPendentes' => Pedido::where('status', 'pendente')->count(),
            'totalProcessando' => Pedido::where('status', 'processando')->count(),
        ]);
    }
}