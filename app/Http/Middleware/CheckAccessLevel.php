<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccessLevel
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $minLevel = 1): Response
    {
        // Verificar se usuário está logado
        if (!session('user')) {
            return redirect()->route('login')->with('LoginError', 'Faça login para acessar.');
        }

        // Verificar se tem access_level suficiente
        $userAccessLevel = session('user.access_level', 0);

        if ($userAccessLevel < $minLevel) {
            return redirect()->route('home')->with('error', 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
