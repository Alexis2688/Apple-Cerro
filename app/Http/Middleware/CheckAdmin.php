<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    if (auth()->check() && auth()->user()->admin) {
        return $next($request);
    }

    // Redirige al login con un mensaje de error
    return redirect()->route('login')->with('error', '¡Acceso restringido! Debes ser administrador.');
}
}
