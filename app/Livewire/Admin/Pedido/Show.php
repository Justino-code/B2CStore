<?php

namespace App\Livewire\Admin\Pedido;

use Livewire\Component;
use App\Models\Pedido;
use Barryvdh\DomPDF\Facade\Pdf;

use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Show extends Component
{
    public $pedido;
    public $pedidoId;
    public $notaFiscalGerada = false;

    public function mount($id)
    {
        $this->pedidoId = $id;
        $this->carregarPedido();
    }

    public function carregarPedido()
    {
        $this->pedido = Pedido::with([
            'usuario',
            'pagamento',
            'cupom',
            'itens' => function($query) {
                $query->with('produto.imagens');
            }
        ])->findOrFail($this->pedidoId);
    }

    public function atualizarStatus($novoStatus)
    {
        $this->pedido->update(['status' => $novoStatus]);
        $this->carregarPedido();
        
        // Aqui você pode adicionar lógica para enviar notificação ao cliente
        session()->flash('success', 'Status do pedido atualizado para ' . $this->getStatusLabel($novoStatus) . '!');
    }

    public function gerarNotaFiscal()
    {
        $this->notaFiscalGerada = true;
        
        // Gerar PDF da nota fiscal
        $pdf = Pdf::loadView('admin.pedidos.nota-fiscal', ['pedido' => $this->pedido]);
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'nota-fiscal-' . $this->pedido->codigo_pedido . '.pdf');
    }

    public function reenviarConfirmacao()
    {
        // Lógica para reenviar confirmação de pedido por email
        session()->flash('success', 'Confirmação de pedido reenviada para o cliente!');
    }

    public function getStatusLabel($status)
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
        return view('livewire.admin.pedido.show');
    }
}