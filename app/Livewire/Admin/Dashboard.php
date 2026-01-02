<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Usuario as User;
use Carbon\Carbon;

use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    public $periodo = 'hoje'; // hoje, semana, mes, ano
    public $dadosDashboard;

    public function mount()
    {
        $this->carregarDados();
    }

    public function carregarDados()
    {
        $dataInicio = $this->getDataInicio();

        // Dados de vendas
        $vendas = Pedido::where('status', 'entregue')
            ->where('created_at', '>=', $dataInicio)
            ->get();

        $totalVendas = $vendas->sum('total');
        $totalProdutosVendidos = $vendas->sum(function($pedido) {
            return $pedido->itens->sum('quantidade');
        });

        // Status dos pedidos
        $pedidosStatus = [
            'pendente' => Pedido::where('status', 'pendente')->count(),
            'processando' => Pedido::where('status', 'processando')->count(),
            'enviado' => Pedido::where('status', 'enviado')->count(),
            'entregue' => Pedido::where('status', 'entregue')->count(),
            'cancelado' => Pedido::where('status', 'cancelado')->count(),
        ];

        // Resumo financeiro
        $receita = $totalVendas;
        $pagamentosPendentes = Pedido::whereIn('status', ['pendente', 'processando'])->sum('total');

        // Últimos pedidos
        $ultimosPedidos = Pedido::with('usuario')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Produtos com estoque baixo
        $estoqueBaixo = Produto::where('estoque', '<', 10)
            ->where('ativo', true)
            ->with('imagens')
            ->take(5)
            ->get();

        $this->dadosDashboard = [
            'totalVendas' => $totalVendas,
            'totalProdutosVendidos' => $totalProdutosVendidos,
            'pedidosStatus' => $pedidosStatus,
            'receita' => $receita,
            'pagamentosPendentes' => $pagamentosPendentes,
            'saldo' => $receita - $pagamentosPendentes,
            'ultimosPedidos' => $ultimosPedidos,
            'estoqueBaixo' => $estoqueBaixo,
            'totalClientes' => User::where('role', 'cliente')->count(),
            'totalProdutos' => Produto::count(),
        ];
    }

    private function getDataInicio()
    {
        $now = Carbon::now();
        
        return match($this->periodo) {
            'hoje' => $now->startOfDay(),
            'semana' => $now->startOfWeek(),
            'mes' => $now->startOfMonth(),
            'ano' => $now->startOfYear(),
            default => $now->startOfDay(),
        };
    }

    public function alterarPeriodo($periodo)
    {
        $this->periodo = $periodo;
        $this->carregarDados();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}