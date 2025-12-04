<?php

namespace App\Traits;

trait WithNotifications
{
    /**
     * Mostrar notificação toast
     */
    public function notify($type, $message, $options = [])
    {
        $this->dispatch('showNotification', [
            'type' => $type,
            'message' => $message,
            'options' => $options
        ]);
    }

    /**
     * Atalhos para tipos específicos
     */
    public function notifySuccess($message, $options = [])
    {
        $this->notify('success', $message, $options);
    }

    public function notifyError($message, $options = [])
    {
        $this->notify('error', $message, $options);
    }

    public function notifyWarning($message, $options = [])
    {
        $this->notify('warning', $message, $options);
    }

    public function notifyInfo($message, $options = [])
    {
        $this->notify('info', $message, $options);
    }

    /**
     * Mostrar diálogo de confirmação
     */
    public function confirm($options = [])
    {
        $defaults = [
            'title' => 'Confirmar ação',
            'message' => 'Tem certeza que deseja continuar?',
            'confirmText' => 'Confirmar',
            'cancelText' => 'Cancelar',
            'confirmColor' => 'danger',
            'method' => null,
            'params' => [],
        ];

        $this->dispatch('showConfirmation', array_merge($defaults, $options));
    }

    /**
     * Confirmar exclusão (atalho comum)
     */
    public function confirmDelete($itemName = 'este item', $method = 'delete', $params = [])
    {
        $this->confirm([
            'title' => 'Confirmar exclusão',
            'message' => "Tem certeza que deseja excluir {$itemName}? Esta ação não pode ser desfeita.",
            'confirmText' => 'Sim, excluir!',
            'confirmColor' => 'danger',
            'method' => $method,
            'params' => $params,
        ]);
    }
}
