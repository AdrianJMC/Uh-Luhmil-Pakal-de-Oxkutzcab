<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // Mostrar listado de perfiles y permisos
    public function index()
    {
        $roles = Role::all();
        $allPermissions = Permission::all();

        return view('admin.users.Gestion-de-Usuarios', compact('roles', 'allPermissions'));
    }

    // Crear nuevo perfil
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'description' => 'nullable|string',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $role->syncPermissions($request->permissions ?? []);

        // Redirige a la pestaña de Perfiles con mensaje
        return redirect()->route('admin.users.index', ['tab' => 'perfiles'])
            ->with('success', 'Perfil creado correctamente.');
    }

    // Actualizar los permisos asignados al perfil
    public function updatePermissions(Request $request, Role $role)
    {
        $role->syncPermissions($request->permissions ?? []);

        // Redirige a la pestaña de Perfiles con mensaje
        return redirect()->route('admin.users.index', ['tab' => 'perfiles'])
            ->with('success', 'Permisos del perfil actualizados.');
    }

    // Crear perfil
    public function create()
    {
        $allPermissions = Permission::all();
        return view('admin.users._roles-create', compact('allPermissions'));
    }

    // Editar perfil
    public function edit(Role $role)
    {
        $allPermissions = Permission::all();
        return view('admin.users._roles-edit', compact('role', 'allPermissions'));
    }

    // Actualizar un perfil
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $role->syncPermissions($request->permissions ?? []);

        // Redirige a la pestaña de Perfiles con mensaje
        return redirect()->route('admin.users.index', ['tab' => 'perfiles'])
            ->with('success', 'Perfil actualizado correctamente.');
    }

    // Eliminar un perfil
    public function destroy(Role $role)
    {
        $role->delete();

        // Redirige a la pestaña de Perfiles con mensaje
        return redirect()->route('admin.users.index', ['tab' => 'perfiles'])
            ->with('success', 'Perfil eliminado correctamente.');
    }
}
