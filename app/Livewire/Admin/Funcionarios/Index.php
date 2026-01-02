<?php

namespace App\Livewire\Admin\Funcionarios;

use App\Models\Usuario;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

use Livewire\Attributes\On;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';
    public $status = '';
    public $sortField = 'nome';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $selectedFuncionarios = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'nome'],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 10],
    ];

    public function mount()
    {
        // Garantir que apenas funcionários sejam mostrados (não clientes)
        $this->role = 'admin'; // Definir um filtro padrão
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedFuncionarios = $this->funcionariosQuery->pluck('id_usuario')->toArray();
        } else {
            $this->selectedFuncionarios = [];
        }
    }

    public function updatedSelectedFuncionarios()
    {
        $this->selectAll = false;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete($funcionario)
    {
        $this->dispatch('confirm', 
            title: 'Excluir Funcionário',
            text: 'Tem certeza que deseja excluir o funcionario "' . $funcionario['nome'] . '"?',
            icon: 'warning',
            confirmButtonText: 'Sim, excluir',
            method: 'deletar-funcionario',
            params: [(int)$funcionario['id_usuario']],
        );
    }

    #[On('deletar-funcionario')]
    public function deleteFuncionario($id)
    {
        $funcionario = Usuario::find($id);
        
        // Não permitir deletar o próprio usuário
        if ($funcionario->id_usuario === auth()->id()) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Você não pode deletar sua própria conta!'
            );
            return;
        }

        // Não permitir deletar o último admin
        if ($funcionario->role === 'admin') {
            $adminCount = Usuario::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                $this->dispatch('notify',
                    type: 'error',
                    message: 'Não é possível deletar o único administrador do sistema!'
                );
                return;
            }
        }

        try {
            $funcionario->delete();
            
            $this->dispatch('notify',
                type: 'success',
                message: 'Funcionário deletado com sucesso!'
            );
            
            // Remover da seleção
            $this->selectedFuncionarios = array_diff($this->selectedFuncionarios, [$id]);
            
        } catch (\Exception $e) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Erro ao deletar funcionário.'
            );
        }
    }

    #[On('deleteSelected')]
    public function deleteSelected()
    {
        if (empty($this->selectedFuncionarios)) {
            return;
        }

        // Verificar se o usuário atual está na lista
        if (in_array(auth()->id(), $this->selectedFuncionarios)) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Você não pode deletar sua própria conta!'
            );
            return;
        }

        try {
            // Verificar se vai deletar o último admin
            $selectedAdmins = Usuario::whereIn('id_usuario', $this->selectedFuncionarios)
                ->where('role', 'admin')
                ->count();
            
            $totalAdmins = Usuario::where('role', 'admin')->count();
            
            if ($selectedAdmins >= $totalAdmins) {
                $this->dispatch('notify',
                    type: 'error',
                    message: 'Não é possível deletar todos os administradores do sistema!'
                );
                return;
            }

            Usuario::whereIn('id_usuario', $this->selectedFuncionarios)->delete();
            
            $this->dispatch('notify',
                type: 'success',
                message: count($this->selectedFuncionarios) . ' funcionário(s) deletado(s) com sucesso!'
            );
            
            $this->selectedFuncionarios = [];
            $this->selectAll = false;
            
        } catch (\Exception $e) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Erro ao deletar funcionários.'
            );
        }
    }

    public function exportFuncionarios()
    {
        $funcionarios = $this->funcionariosQuery->get();
        
        $headers = [
            'ID',
            'Nome',
            'Email',
            'Telefone',
            'Cargo',
            'Status',
            'Data de Cadastro',
            'Último Login'
        ];
        
        $rows = [];
        foreach ($funcionarios as $funcionario) {
            $rows[] = [
                $funcionario->id_usuario,
                $funcionario->nome,
                $funcionario->email,
                $funcionario->telefone ?? 'Não informado',
                $this->getRoleLabel($funcionario->role),
                $funcionario->status === 'ativo' ? 'Ativo' : 'Inativo',
                $funcionario->created_at->format('d/m/Y H:i'),
                $funcionario->last_login_at?->format('d/m/Y H:i') ?? 'Nunca logou'
            ];
        }
        
        $this->dispatch('export-csv', [
            'filename' => 'funcionarios_' . date('Y-m-d_H-i') . '.csv',
            'headers' => $headers,
            'rows' => $rows
        ]);
    }

    private function getRoleLabel($role)
    {
        return match($role) {
            'admin' => 'Administrador',
            'gerente' => 'Gerente',
            'operador' => 'Operador',
            'suporte' => 'Suporte',
            default => ucfirst($role)
        };
    }

    public function getEstatisticasProperty()
    {
        return [
            'totalFuncionarios' => Usuario::whereNot('role', 'cliente')->count(),
            'funcionariosAtivos' => Usuario::whereNot('role', 'cliente')
                ->where('status', 'ativo')
                ->count(),
            'novosEsteMes' => Usuario::whereNot('role', 'cliente')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'porRole' => Usuario::whereNot('role', 'cliente')
                ->select('role', DB::raw('count(*) as total'))
                ->groupBy('role')
                ->pluck('total', 'role')
                ->toArray()
        ];
    }

    public function getFuncionariosQueryProperty()
    {
        $query = Usuario::whereNot('role', 'cliente')
            ->withCount(['pedidos'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nome', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('telefone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->role, function ($query) {
                $query->where('role', $this->role);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            });

        // Ordenação
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }

    public function getFuncionariosProperty()
    {
        return $this->funcionariosQuery->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.funcionarios.index', [
            'funcionarios' => $this->funcionarios,
            'estatisticas' => $this->estatisticas
        ]);
    }
}