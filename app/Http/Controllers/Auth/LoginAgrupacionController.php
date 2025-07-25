<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agrupacion;

class LoginAgrupacionController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.agrupaciones-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Intentamos autenticar usando el guard "agrupacion"
        if (Auth::guard('agrupacion')->attempt([
            'email_representante' => $request->email,
            'password'            => $request->password,
        ])) {
            // Logout del guard "web" (usuarios) para evitar sesiones cruzadas
            Auth::guard('web')->logout();

            // Opcional: regenerar sesión
            $request->session()->regenerate();

            return redirect()->route('agrupaciones.dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas o agrupación no aprobada.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('agrupacion')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio');
    }
}
