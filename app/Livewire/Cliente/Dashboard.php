<?php

namespace App\Livewire\Cliente;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\Favorito;
use App\Models\Carrinho;

class Dashboard extends Component
{
    public $usuario;
    public $pedidosRecentes;
    public $totalFavoritos;
    public $totalCarrinho;
    public $pedidosAndamento;
    public $pedidosEntregues;

    public function mount()
    {
        $this->usuario = Auth::user();
        $this->carregarDados();
    }

    public function carregarDados()
    {
        // Pedidos recentes (últimos 5)
        $this->pedidosRecentes = Pedido::where('id_usuario', $this->usuario->id_usuario)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Contagem de favoritos
        $this->totalFavoritos = Favorito::where('id_usuario', $this->usuario->id_usuario)->count();

        // Contagem de itens no carrinho
        $carrinho = Carrinho::where('id_usuario', $this->usuario->id_usuario)->first();
        $this->totalCarrinho = $carrinho ? $carrinho->itens()->count() : 0;

        // Pedidos em andamento
        $this->pedidosAndamento = Pedido::where('id_usuario', $this->usuario->id_usuario)
            ->whereIn('status', ['pendente', 'processando', 'enviado'])
            ->count();

        // Pedidos entregues
        $this->pedidosEntregues = Pedido::where('id_usuario', $this->usuario->id_usuario)
            ->where('status', 'entregue')
            ->count();
    }

    public function render()
    {
        return view('livewire.cliente.dashboard')
            ->layout('components.layouts.cliente', [
                'titulo' => 'Dashboard - B2CStore'
            ]);
    }
}