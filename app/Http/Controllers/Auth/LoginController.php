<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        // middleware configurado como antes
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Después de login exitoso, desconecta el guard 'agrupacion'.
     */
    protected function authenticated(Request $request, $user)
    {
        // Cierra sesión de agrupación si la hubiera
        Auth::guard('agrupacion')->logout();

        $carrito = \App\Models\Carrito::where('user_id', $user->id)->first();

        if ($carrito) {
            session()->put('cart', $carrito->items);
        }

        return redirect()->intended('/');
    }
}
