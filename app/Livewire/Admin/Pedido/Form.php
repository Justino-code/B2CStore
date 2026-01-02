<?php

namespace App\Livewire\Admin\Pedido;

use Livewire\Component;
use App\Models\Pedido;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoStatusAtualizado;

use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Form extends Component
{
    public $pedido;
    public $pedidoId;
    
    // Status
    public $status;
    public $novoStatus;
    
    // Envio
    public $codigoRastreamento;
    public $transportadora;
    public $dataEntregaPrevista;
    
    // Notificações
    public $enviarEmailCliente = true;
    public $mensagemAdicional = '';

    public function mount($id)
    {
        $this->pedidoId = $id;
        $this->carregarPedido();
    }

    public function carregarPedido()
    {
        $this->pedido = Pedido::with(['usuario', 'itens.produto'])->findOrFail($this->pedidoId);
        $this->status = $this->pedido->status;
        $this->novoStatus = $this->pedido->status;
    }

    public function rules()
    {
        return [
            'novoStatus' => 'required|in:pendente,processando,enviado,entregue,cancelado',
            'codigoRastreamento' => 'nullable|string|max:100',
            'transportadora' => 'nullable|string|max:100',
            'dataEntregaPrevista' => 'nullable|date|after_or_equal:today',
            'mensagemAdicional' => 'nullable|string|max:500',
        ];
    }

    public function atualizarStatus()
    {
        $this->validate();

        try {
            \DB::beginTransaction();

            $statusAnterior = $this->pedido->status;
            
            // Atualizar status do pedido
            $this->pedido->update([
                'status' => $this->novoStatus,
                'metodo_envio' => $this->transportadora ?: $this->pedido->metodo_envio,
                'data_entrega' => $this->dataEntregaPrevista ?: $this->pedido->data_entrega,
            ]);

            // Se tiver código de rastreamento, salvar nos detalhes
            if ($this->codigoRastreamento) {
                // Aqui você pode adicionar lógica para salvar o código de rastreamento
                // em uma tabela específica ou nos detalhes do pedido
                $this->pedido->update([
                    'observacoes' => $this->pedido->observacoes . 
                                    "\n\nCódigo de rastreamento: " . $this->codigoRastreamento . 
                                    "\nTransportadora: " . ($this->transportadora ?: 'Não informada')
                ]);
            }

            // Registrar histórico de status
            $this->registrarHistorico($statusAnterior, $this->novoStatus);

            // Enviar email de notificação
            if ($this->enviarEmailCliente && $statusAnterior !== $this->novoStatus) {
                $this->enviarEmailNotificacao($statusAnterior, $this->novoStatus);
            }

            \DB::commit();

            session()->flash('success', 'Status do pedido atualizado com sucesso!');
            
            if ($this->enviarEmailCliente) {
                session()->flash('info', 'Notificação enviada para o cliente.');
            }

            return redirect()->route('admin.pedidos.show', $this->pedidoId);

        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('error', 'Erro ao atualizar pedido: ' . $e->getMessage());
        }
    }

    private function registrarHistorico($statusAnterior, $novoStatus)
    {
        // Aqui você pode implementar a lógica para registrar o histórico de status
        // Por exemplo, em uma tabela 'pedido_historico'
        \DB::table('pedido_historico')->insert([
            'id_pedido' => $this->pedidoId,
            'status_anterior' => $statusAnterior,
            'novo_status' => $novoStatus,
            'observacoes' => $this->mensagemAdicional,
            'codigo_rastreamento' => $this->codigoRastreamento,
            'transportadora' => $this->transportadora,
            'criado_por' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function enviarEmailNotificacao($statusAnterior, $novoStatus)
    {
        try {
            Mail::to($this->pedido->usuario->email)
                ->send(new PedidoStatusAtualizado(
                    $this->pedido,
                    $statusAnterior,
                    $novoStatus,
                    $this->mensagemAdicional,
                    $this->codigoRastreamento,
                    $this->transportadora
                ));
        } catch (\Exception $e) {
            // Logar erro mas não impedir a atualização
            \Log::error('Erro ao enviar email de notificação: ' . $e->getMessage());
        }
    }

    public function getStatusOptionsProperty()
    {
        $opcoes = [
            'pendente' => [
                'label' => 'Pendente',
                'cor' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                'proximos' => ['processando', 'cancelado']
            ],
            'processando' => [
                'label' => 'Em Processamento',
                'cor' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                'proximos' => ['enviado', 'cancelado']
            ],
            'enviado' => [
                'label' => 'Enviado',
                'cor' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
                'proximos' => ['entregue']
            ],
            'entregue' => [
                'label' => 'Entregue',
                'cor' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                'proximos' => []
            ],
            'cancelado' => [
                'label' => 'Cancelado',
                'cor' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                'proximos' => []
            ],
        ];

        return $opcoes;
    }

    public function render()
    {
        return view('livewire.admin.pedido.form');
    }
}