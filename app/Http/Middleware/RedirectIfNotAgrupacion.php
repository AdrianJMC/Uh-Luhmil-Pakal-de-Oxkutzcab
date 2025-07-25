<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAgrupacion
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('agrupacion')->check()) {
            return redirect()->route('agrupaciones.login');
        }

        return $next($request);
    }
}
