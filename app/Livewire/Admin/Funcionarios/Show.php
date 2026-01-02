<?php

namespace App\Livewire\Admin\Funcionarios;

use App\Models\Usuario;
use Livewire\Component;

use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Show extends Component
{
    public Usuario $funcionario;
    public $activeTab = 'perfil';

    public function mount(Usuario $funcionario)
    {
        $this->funcionario = $funcionario->load(['pedidos', 'reviews']);
        
        // Garantir que não estamos mostrando um cliente
        if ($funcionario->role === 'cliente') {
            abort(404, 'Cliente não encontrado');
        }
    }

    public function getEnderecoFormatado()
    {
        return $this->funcionario->endereco_formatado;
    }

    public function getRoleLabel($role)
    {
        return match($role) {
            'admin' => 'Administrador',
            'gerente' => 'Gerente',
            'operador' => 'Operador',
            'suporte' => 'Suporte',
            default => ucfirst($role)
        };
    }

    public function getRoleColor($role)
    {
        return match($role) {
            'admin' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            'gerente' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
            'operador' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'suporte' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300'
        };
    }

    public function render()
    {
        return view('livewire.admin.funcionarios.show');
    }
}