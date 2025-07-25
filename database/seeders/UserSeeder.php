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
        // 1. Crear el rol super-admin si no existe
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // 2. Asignar todos los permisos disponibles al rol
        $superAdminRole->syncPermissions(Permission::all());

        // 3. Crear el primer usuario
        $user = User::firstOrCreate(
            ['email' => 'UhLuhmilPakal@gmail.com'],
            [
                'name' => 'Uh Luhmil Pakal',
                'password' => bcrypt('GzP#8w!vXq@r4LsZ'), // Asegúrate de usar un hash seguro
            ]
        );

        // 4. Asignar el rol super-admin al usuario
        $user->assignRole($superAdminRole);
    }
}
