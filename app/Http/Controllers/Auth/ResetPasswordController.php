<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Models\User;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    // Redirige al login después de cambiar la contraseña
    protected function sendResetResponse(Request $request, $response)
    {
        return redirect()->route('login')->with('status', trans($response));
    }

    // Sobreescribe el método para evitar loguear al usuario
    protected function resetPassword(User $user, $password)
    {
        $user->password = $password; // Laravel lo hashea automáticamente gracias a 'password' => 'hashed'
        $user->save(); // Esto ya no da error porque ahora está tipado correctamente
    }
}
