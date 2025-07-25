<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agrupacion;
use Illuminate\Support\Facades\Hash;

class AgrupacionPasswordController extends Controller
{
    public function showForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.agrupaciones.crear-password', compact('email'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:agrupaciones,email_representante',
            'password' => 'required|min:8|confirmed',
        ]);

        $agrupacion = Agrupacion::where('email_representante', $request->email)->firstOrFail();
        $agrupacion->password = Hash::make($request->password);
        $agrupacion->save();

        return redirect()->route('agrupaciones.login')->with('success', 'Contraseña creada correctamente. Ahora puedes iniciar sesión.');
    }
}
