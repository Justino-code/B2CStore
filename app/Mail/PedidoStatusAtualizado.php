<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pedido;

class PedidoStatusAtualizado extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;
    public $statusAnterior;
    public $novoStatus;
    public $mensagemAdicional;
    public $codigoRastreamento;
    public $transportadora;

    public function __construct($pedido, $statusAnterior, $novoStatus, $mensagemAdicional = '', $codigoRastreamento = '', $transportadora = '')
    {
        $this->pedido = $pedido;
        $this->statusAnterior = $statusAnterior;
        $this->novoStatus = $novoStatus;
        $this->mensagemAdicional = $mensagemAdicional;
        $this->codigoRastreamento = $codigoRastreamento;
        $this->transportadora = $transportadora;
    }

    public function build()
    {
        return $this->subject('Atualização do seu pedido #' . $this->pedido->codigo_pedido)
                    ->markdown('emails.pedido-status-atualizado')
                    ->with([
                        'pedido' => $this->pedido,
                        'statusAnterior' => $this->statusAnterior,
                        'novoStatus' => $this->novoStatus,
                        'mensagemAdicional' => $this->mensagemAdicional,
                        'codigoRastreamento' => $this->codigoRastreamento,
                        'transportadora' => $this->transportadora,
                    ]);
    }
}