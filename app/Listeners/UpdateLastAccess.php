<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UpdateLastAccess
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $event->user->forceFill([
            'ultimo_acesso' => now(),
            'ultimo_acesso_ip' => request()->ip(), // pega o IP do usuário
        ])->save();
    }
}
