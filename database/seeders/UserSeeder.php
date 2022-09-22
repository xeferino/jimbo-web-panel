<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //roles
        $super_admin    = Role::create(['name' => 'super-admin', 'description' => 'Super Administrador, acceso completo a la aplicacion']);
        $administrator  = Role::create(['name' => 'administrator', 'description' => 'Administrador del panel de jimbo sorteos']);
        $seller    = Role::create(['name' => 'seller', 'description' => 'Vendedor, administra ventas en el app.']);

        //permissions roles
        Permission::create(['name' => 'create-role', 'description' => 'Crear rol en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'edit-role', 'description' => 'Editar rol en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'show-role', 'description' => 'listado y detalle de rol en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'delete-role', 'description' => 'Eliminar de rol en el sistema'])->syncRoles([$super_admin]);

        //permissions users
        Permission::create(['name' => 'create-user', 'description' => 'Crear usuario en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'edit-user', 'description' => 'Editar usuario en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'show-user', 'description' => 'listado y detalle de usuario en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'delete-user', 'description' => 'Eliminar de usuario en el sistema'])->syncRoles([$super_admin, $administrator]);

        //permissions countries
        Permission::create(['name' => 'create-country', 'description' => 'Crear pais en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'edit-country', 'description' => 'Editar pais en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'show-country', 'description' => 'listado y detalle de pais en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'delete-country', 'description' => 'Eliminar de pais en el sistema'])->syncRoles([$super_admin, $administrator]);

        //permissions menu
        Permission::create(['name' => 'setting-menu', 'description' => 'menu de configuracion en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'user-menu', 'description' => 'menu de configuracion de usuarios en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'role-menu', 'description' => 'menu de configuracion de roles en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'dashboard-menu', 'description' => 'menu de tablero de informacion de balances y estadisticas en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'country-menu', 'description' => 'menu de configuracion de paises en el sistema'])->syncRoles([$super_admin]);

        User::create([
            'name' => 'Super Admin',
            'email' => 'super-admin@jimbosorteos.com',
            'password' => Hash::make('admin'),
        ])->assignRole($super_admin);
    }
}
