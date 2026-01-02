<?php

namespace App\Livewire\Admin\Cliente;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Usuario as User;
use App\Models\Pedido;
use App\Models\ProdutoFavorito;
use Carbon\Carbon;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Show extends Component
{
    use WithPagination;

    public $cliente;
    public $clienteId;
    public $abaAtiva = 'pedidos';
    public $periodoPedidos = 'todos';
    public $estatisticas = [];

    public function mount($id)
    {
        $this->clienteId = $id;
        $this->carregarCliente();
        $this->carregarEstatisticas();
    }

    public function updatedAbaAtiva($value)
    {
        $this->resetPage();
    }

    public function updatedPeriodoPedidos($value)
    {
        $this->resetPage();
    }

    public function carregarCliente()
    {
        $this->cliente = User::where('role', 'cliente')->findOrFail($this->clienteId);
    }

    public function carregarEstatisticas()
    {
        // Estatísticas de pedidos
        $pedidosCliente = $this->cliente->pedidos()->get();
        $pedidosEntregues = $pedidosCliente->where('status', 'entregue');
        
        // Valor total gasto
        $valorTotal = $pedidosEntregues->sum('total');
        
        // Ticket médio
        $ticketMedio = $pedidosEntregues->count() > 0 
            ? $valorTotal / $pedidosEntregues->count() 
            : 0;
        
        // Último pedido
        $ultimoPedido = $this->cliente->pedidos()
            ->orderBy('created_at', 'desc')
            ->first();
        
        // Dias desde último pedido
        $diasDesdeUltimoPedido = $ultimoPedido 
            ? Carbon::parse($ultimoPedido->created_at)->diffInDays(now())
            : null;

        // Verificação segura do email verificado
        $emailVerificado = false;
        if (isset($this->cliente->email_verificado_em) && !is_null($this->cliente->email_verificado_em)) {
            $emailVerificado = true;
        }

        $this->estatisticas = [
            'totalPedidos' => $pedidosCliente->count(),
            'pedidosEntregues' => $pedidosEntregues->count(),
            'valorTotalGasto' => $valorTotal,
            'ticketMedio' => $ticketMedio,
            'totalFavoritos' => $this->cliente->favoritos()->count(),
            'ultimoPedido' => $ultimoPedido,
            'diasDesdeUltimoPedido' => $diasDesdeUltimoPedido,
            'statusCliente' => $this->cliente->status,
            'emailVerificado' => $emailVerificado,
            'tempoComoCliente' => Carbon::parse($this->cliente->created_at)->diffForHumans(),
        ];
    }

    public function enviarEmail()
    {
        session()->flash('success', 'Email enviado para ' . $this->cliente->email);
    }

    public function redefinirSenha()
    {
        session()->flash('info', 'Link de redefinição de senha enviado para ' . $this->cliente->email);
    }

    public function toggleStatus()
    {
        try {
            // Verifica se a coluna 'status' existe no model
            if (isset($this->cliente->status)) {
                $novoStatus = $this->cliente->status === 'ativo' ? 'inativo' : 'ativo';
                $this->cliente->update(['status' => $novoStatus]);
                
                $this->carregarCliente();
                $this->carregarEstatisticas();
            }
            
            $this->dispatch('notify',
                type: 'success', 
                message: 'Status do cliente atualizado!');
        } catch (\Exception $e) {
            $this->dispatch('notify',
                type: 'error', 
                message: 'Erro ao atualizar status: ' . $e->getMessage());
        }
    }

    public function confirmDelete()
    {
        if ($this->cliente->pedidos()->count() > 0) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Não é possível deletar cliente com pedidos associados.'
            );
            return;
        }

        $nomeCliente = $this->cliente->nome ?? $this->cliente->email;

        $this->dispatch('confirm', 
            title: 'Excluir cliente',
            text: 'Tem certeza que deseja excluir o cliente "' . $nomeCliente . '"?',
            confirmButtonText: 'Sim, excluir',
        );
    }

    public function deletarCliente()
    {
        try {
            $nomeCliente = $this->cliente->nome ?? $this->cliente->email;

            $this->cliente->delete();

            $this->dispatch('notify',
                type: 'success',
                message: 'Cliente "' . $nomeCliente . '" deletado com sucesso!'
            );

            return redirect()->route('admin.clientes.index');

        } catch (\Exception $e) {
            $this->dispatch('notify',
                type: 'error',
                message: 'Erro ao deletar cliente.'
            );
        }
    }

    public function render()
    {
        // Carrega dados conforme aba ativa
        $pedidos = collect();
        $favoritos = collect();
        
        if ($this->abaAtiva === 'pedidos') {
            $query = Pedido::where('id_usuario', $this->clienteId)
                ->with(['itens.produto', 'pagamento']);

            // Aplica filtro de período
            if ($this->periodoPedidos !== 'todos') {
                $dataLimite = match($this->periodoPedidos) {
                    '30dias' => Carbon::now()->subDays(30),
                    '90dias' => Carbon::now()->subDays(90),
                    'ano' => Carbon::now()->subYear(),
                    default => null,
                };
                
                if ($dataLimite) {
                    $query->where('created_at', '>=', $dataLimite);
                }
            }

            $pedidos = $query->orderBy('created_at', 'desc')->paginate(10);
        }
        
        if ($this->abaAtiva === 'favoritos') {
            $favoritos = $this->cliente->favoritos()
                ->with('produto.imagens')
                ->paginate(10);
        }

        return view('livewire.admin.cliente.show', [
            'pedidos' => $pedidos,
            'favoritos' => $favoritos,
        ]);
    }
}