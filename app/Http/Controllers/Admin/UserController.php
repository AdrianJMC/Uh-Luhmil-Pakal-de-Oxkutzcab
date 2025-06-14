<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $roles = Role::all();
        $allPermissions = Permission::all();
        // Este array es el que el script JS necesita para autocompletar
        $usuariosData = $users->map(function ($u) {
            return [
                'id' => $u->id,
                'nombre' => $u->name,
                'apellido' => $u->apellido ?? '',
                'email' => $u->email,
            ];
        });

        return view('admin.users.Gestion-de-Usuarios', compact('users', 'roles', 'usuariosData', 'allPermissions'));
    }

    
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index', ['tab' => 'usuarios'])
            ->with('user_success', 'Usuario eliminado correctamente.');
    }

    public function updateRoles(Request $req, User $user)
    {
        $user->syncRoles($req->roles ?? []);
        return redirect()->route('admin.users.index', ['tab' => 'usuarios'])
            ->with('user_success', 'Roles actualizados correctamente.');
    }
}
