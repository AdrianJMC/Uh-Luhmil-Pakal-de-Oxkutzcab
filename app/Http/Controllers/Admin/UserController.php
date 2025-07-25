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
        $query = User::orderBy('created_at', 'desc');

        if ($request->filled('buscar')) {
            $busqueda = strtolower($request->input('buscar'));
            $query->where(function ($q) use ($busqueda) {
                $q->whereRaw('LOWER(id) LIKE ?', ["%$busqueda%"])
                    ->orWhereRaw('LOWER(name) LIKE ?', ["%$busqueda%"])
                    ->orWhereRaw('LOWER(apellido) LIKE ?', ["%$busqueda%"])
                    ->orWhereRaw('LOWER(email) LIKE ?', ["%$busqueda%"]);
            });     
        }

        $users = $query->paginate(25, ['*'], 'usuarios_page'); // usa 25 reales
        $roles = Role::orderBy('name')->paginate(10, ['*'], 'roles_page');
        $allPermissions = Permission::all();

        $usuariosData = $users->getCollection()->map(function ($u) {
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
