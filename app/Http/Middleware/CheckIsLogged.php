<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsLogged
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('user')) {
            return redirect()->route('login')->with('LoginError', 'Faça login para acessar.');
        }
        return $next($request);
    }
}
