<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AtualizarUltimoAcesso
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Atualizar último acesso se o usuário estiver autenticado
        if (Auth::check()) {
            $user = Auth::user();
            
            // Atualizar apenas se passaram mais de 1 minuto desde o último acesso
            if (!$user->ultimo_acesso || $user->ultimo_acesso->diffInMinutes(now()) >= 1) {
                $user->atualizarUltimoAcesso();
            }
        }

        return $response;
    }
}