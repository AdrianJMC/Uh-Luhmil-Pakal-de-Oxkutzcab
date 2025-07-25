<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TieneRolMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->roles->isEmpty()) {
            abort(403, 'Acceso denegado: no tienes ningún rol asignado.');
        }

        return $next($request);
    }
}
