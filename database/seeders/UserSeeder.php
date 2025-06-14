<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear permisos base si no existen
        $permisos = [
            'ver_usuarios',
            'editar_usuarios',
            'gestionar_perfiles',
            'editar_contenido',
            'ver_paginas',
            'crear_slides',
            'dar_alta_agrupaciones',
            'dar_baja_agrupaciones',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // 2. Crear rol super-admin con todos los permisos
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdminRole->syncPermissions(Permission::all());

        // 3. Crear usuario con ese rol
        $user = User::factory()->create([
            'name'     => 'Uh Luhmil Pakal',
            'email'    => 'UhLuhmilPakal@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->assignRole('super-admin');
    }
}

