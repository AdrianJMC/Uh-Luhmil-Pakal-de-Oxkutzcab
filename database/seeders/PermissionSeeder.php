<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            'ver_usuarios',
            'editar_usuarios',
            'ver_agrupaciones',
            'editar_agrupaciones',
            'crear_cotizaciones',
            'ver_cotizaciones',
            'editar_cotizaciones',
            'borrar_cotizaciones',
            'acceder_dashboard',
            'gestionar_contenido',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }
    }
}
