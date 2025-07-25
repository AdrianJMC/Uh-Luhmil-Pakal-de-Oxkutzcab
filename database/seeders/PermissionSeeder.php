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
            // Usuarios
            'ver_usuarios',
            'buscar_usuarios',
            'editar_usuarios',
            'eliminar_usuarios',

            // Perfiles
            'gestionar_perfiles',
            'crear_perfiles',
            'editar_perfiles',
            'eliminar_perfiles',

            // Secciones Web
            'ver_secciones_web',

            // Logo
            'ver_logo',
            'editar_logo',

            // Página Inicio
            'ver_pagina_inicio',
            'editar_pagina_inicio',

            // Infos
            'ver_infos',
            'crear_infos',
            'editar_infos',
            'eliminar_infos',

            // Slides
            'ver_slides',
            'crear_slides',
            'editar_slides',
            'eliminar_slides',

            // Agrupaciones
            'ver_agrupaciones',
            'buscar_agrupaciones',
            'ver_detalles_agrupacion',
            'editar_agrupacion',
            'eliminar_agrupacion',
            'aprobar_agrupacion',
            'rechazar_agrupacion',

            // Productos
            'ver_productos',
            'buscar_productos',
            'ver_detalles_producto',
            'editar_producto',
            'eliminar_producto',
            'aprobar_producto',
            'aprobar_productos_multiples',
            'rechazar_producto',
            'rechazar_productos_multiples',

            // Catálogos
            'ver_catalogos',
            'crear_catalogo',
            'editar_catalogo',
            'eliminar_catalogo',

            // Pedidos
            'ver_pedidos',
            'ver_productos_pedido',

        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }
    }
}
