<?php
// app/Livewire/Cliente/ClientePage.php
namespace App\Livewire\Cliente;

use Livewire\Component;

class ClientePage extends Component
{
    public $currentRoute;
    
    protected $listeners = ['navigateTo' => 'loadPage'];
    
    public function mount()
    {
        $this->currentRoute = request()->route()->getName();
    }
    
    public function loadPage($routeName, $params = [])
    {
        return $this->redirectRoute($routeName, $params, navigate: true);
    }
    
    public function render()
    {
        return view('livewire.cliente.cliente-page');
    }
}