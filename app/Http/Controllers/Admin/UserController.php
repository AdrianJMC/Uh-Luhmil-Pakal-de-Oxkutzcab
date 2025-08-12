<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

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

    public function updateRoles(Request $request, User $user)
    {
        // Validar que se haya seleccionado un solo rol
        $request->validate([
            'roles' => ['required', 'array', 'min:1', 'max:1'],
            'roles.0' => ['nullable', 'string', Rule::exists('roles', 'name')],
        ], [
            'roles.required' => 'Debes seleccionar un rol.',
            'roles.min' => 'Debes seleccionar al menos un rol.',
            'roles.max' => 'Solo puedes asignar un rol por usuario.',
            'roles.0.exists' => 'El rol seleccionado no es válido.',
        ]);


        // Asignar solo el primer rol
        $roles = $request->roles ?? [];
        $selected = $roles[0] ?? null;

        if ($selected === null || $selected === '') {
            $user->syncRoles([]); // quitar todos
        } else {
            $user->syncRoles($selected); // asignar solo uno
        }
        return redirect()->route('admin.users.index', ['tab' => 'usuarios'])
            ->with('user_success', 'Rol actualizado correctamente.');
    }
}
