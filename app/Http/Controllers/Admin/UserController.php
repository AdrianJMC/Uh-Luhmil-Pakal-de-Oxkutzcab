<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $roles = Role::all();

        // Este array es el que el script JS necesita para autocompletar
        $usuariosData = $users->map(function ($u) {
            return [
                'id' => $u->id,
                'nombre' => $u->name,
                'apellido' => $u->apellido ?? '',
                'email' => $u->email,
            ];
        });

        return view('admin.users.Gestion-de-Usuarios', compact('users', 'roles', 'usuariosData'));
    }


    public function updateRoles(Request $req, User $user)
    {
        $user->syncRoles($req->roles ?? []);
        return back()->with('success', 'Roles actualizados');
    }
}
