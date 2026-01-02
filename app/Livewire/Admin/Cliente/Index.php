<?php

namespace App\Livewire\Admin\Cliente;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Usuario as User;
use App\Models\Pedido;
use Carbon\Carbon;

use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = ''; // ativo, inativo, nunca-comprou
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedClientes = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
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
            $this->selectedClientes = $this->clientes->pluck('id_usuario')->toArray();
        } else {
            $this->selectedClientes = [];
        }
    }

    public function toggleStatus($id)
    {
        $cliente = User::where('role', 'cliente')
            ->find($id);
        if ($cliente) {
            $novoStatus = $cliente->status === 'ativo' ? 'inativo' : 'ativo';

            $cliente->update(['status' => $novoStatus]);
            //$this->carregarCliente();
            session()->flash('success', 'Status do cliente atualizado!');
        }
    }

    public function exportarClientes()
    {
        $clientes = User::where('role', 'cliente')
            ->whereIn('id_usuario', $this->selectedClientes)
            ->withCount('pedidos')
            ->withSum('pedidos', 'total')
            ->get();
        
        session()->flash('info', 'Exportação iniciada para ' . count($clientes) . ' cliente(s).');
    }

    public function enviarEmailLote()
    {
        if (empty($this->selectedClientes)) {
            session()->flash('warning', 'Selecione pelo menos um cliente para enviar email.');
            return;
        }

        $clientes = User::where('role', 'cliente')
            ->whereIn('id_usuario', $this->selectedClientes)->get();
        
        // Aqui você implementaria o envio de email em lote
        session()->flash('success', 'Email enviado para ' . count($clientes) . ' cliente(s).');
    }

    public function getClientesProperty()
    {
        return User::where('role', 'cliente')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nome', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('telefone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                if ($this->status === 'ativo') {
                    // Clientes com pedidos recentes (últimos 90 dias)
                    $query->whereHas('pedidos', function ($q) {
                        $q->where('created_at', '>=', Carbon::now()->subDays(90));
                    });
                } elseif ($this->status === 'inativo') {
                    // Clientes sem pedidos nos últimos 90 dias
                    $query->whereDoesntHave('pedidos', function ($q) {
                        $q->where('created_at', '>=', Carbon::now()->subDays(90));
                    });
                } elseif ($this->status === 'nunca-comprou') {
                    // Clientes que nunca fizeram pedidos
                    $query->doesntHave('pedidos');
                }
            })
            ->withCount(['pedidos', 'pedidos as pedidos_entregues' => function ($query) {
                $query->where('status', 'entregue');
            }])
            ->withSum('pedidos', 'total')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);
    }

    public function getEstatisticasProperty()
    {
        $totalClientes = User::where('role', 'cliente')->count();
        $novosClientesMes = User::where('role', 'cliente')
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();
        
        $clientesAtivos = User::where('role', 'cliente')
            ->whereHas('pedidos', function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(90));
            })
            ->count();
        
        $clientesInativos = User::where('role', 'cliente')
            ->whereDoesntHave('pedidos', function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(90));
            })
            ->count();

        $ticketMedio = Pedido::where('status', 'entregue')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('AVG(total) as ticket_medio')
            ->first()
            ->ticket_medio ?? 0;

        return [
            'totalClientes' => $totalClientes,
            'novosClientesMes' => $novosClientesMes,
            'clientesAtivos' => $clientesAtivos,
            'clientesInativos' => $clientesInativos,
            'ticketMedio' => $ticketMedio,
        ];
    }

    public function render()
    {
        return view('livewire.admin.cliente.index', [
            'clientes' => $this->clientes,
            'estatisticas' => $this->estatisticas,
        ]);
    }
}