<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles Permitted roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        // Não autenticado → redireciona para login
        if (!$user) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Não autenticado'], 401)
                : redirect()->route('login');
        }

        // Normaliza roles do usuário (suporta array ou string)
        $userRoles = is_array($user->role) ? $user->role : [$user->role];

        // Verifica se o usuário tem pelo menos uma role permitida
        $permitido = !empty(array_intersect($userRoles, $roles));

        if (!$permitido) {

            // Log de auditoria
            Log::warning('Tentativa de acesso não autorizado', [
                'usuario_id' => $user->id_usuario,
                'roles_usuario' => $userRoles,
                'roles_permitidas' => $roles,
                'rota' => $request->fullUrl(),
                'metodo' => $request->method(),
                'ip' => $request->ip(),
            ]);

            // Retorno moderno:
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Página não encontrada ou não disponível'], 404);
            }

            // Para web: redireciona para página genérica
            return redirect()->route('unauthorized'); // rota genérica de erro
        }

        return $next($request);
    }
}
