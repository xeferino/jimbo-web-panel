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
        $seller         = Role::create(['name' => 'seller', 'description' => 'Vendedor, administra ventas en el app.']);
        $competitor     = Role::create(['name' => 'competitor', 'description' => 'Concursante de sorteos, administra sus datos en el app.']);

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

        //permissions sellers
        Permission::create(['name' => 'create-seller', 'description' => 'Crear vendedor en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'edit-seller', 'description' => 'Editar vendedor en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'show-seller', 'description' => 'listado y detalle de vendedor en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'delete-seller', 'description' => 'Eliminar de vendedor en el sistema'])->syncRoles([$super_admin, $administrator]);

         //permissions competitors
         Permission::create(['name' => 'create-competitor', 'description' => 'Crear competidor en el sistema'])->syncRoles([$super_admin, $administrator]);
         Permission::create(['name' => 'edit-competitor', 'description' => 'Editar competidor en el sistema'])->syncRoles([$super_admin, $administrator]);
         Permission::create(['name' => 'show-competitor', 'description' => 'listado y detalle de competidor en el sistema'])->syncRoles([$super_admin, $administrator]);
         Permission::create(['name' => 'delete-competitor', 'description' => 'Eliminar de competidor en el sistema'])->syncRoles([$super_admin, $administrator]);


        //permissions countries
        Permission::create(['name' => 'create-country', 'description' => 'Crear pais en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'edit-country', 'description' => 'Editar pais en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'show-country', 'description' => 'listado y detalle de pais en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'delete-country', 'description' => 'Eliminar de pais en el sistema'])->syncRoles([$super_admin, $administrator]);

        //permissions promotions
        Permission::create(['name' => 'create-promotion', 'description' => 'Crear promociones de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'edit-promotion', 'description' => 'Editar promociones de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'show-promotion', 'description' => 'listado y detalle de promociones de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'delete-promotion', 'description' => 'Eliminar de promociones de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);


        //permissions raffles
        Permission::create(['name' => 'create-raffle', 'description' => 'Crear sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'edit-raffle', 'description' => 'Editar sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'show-raffle', 'description' => 'listado y detalle de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'delete-raffle', 'description' => 'Eliminar de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);

        //permissions sliders
        Permission::create(['name' => 'create-slider', 'description' => 'Crear sliders de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'edit-slider', 'description' => 'Editar sliders de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'show-slider', 'description' => 'listado y detalle de sliders de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'delete-slider', 'description' => 'Eliminar de sliders de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);

         //permissions sales
         Permission::create(['name' => 'create-sale', 'description' => 'Crear ventas de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);
         Permission::create(['name' => 'edit-sale', 'description' => 'Editar ventas de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);
         Permission::create(['name' => 'show-sale', 'description' => 'listado y detalle de ventas de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);
         Permission::create(['name' => 'delete-sale', 'description' => 'Eliminar de ventas de sorteos en el sistema'])->syncRoles([$super_admin, $administrator]);

        //permissions menu
        Permission::create(['name' => 'setting-menu', 'description' => 'menu de configuracion en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'user-menu', 'description' => 'menu de configuracion de usuarios en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'seller-menu', 'description' => 'menu de configuracion de vendedores en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'competitor-menu', 'description' => 'menu de configuracion de participantes en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'role-menu', 'description' => 'menu de configuracion de roles en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'dashboard-menu', 'description' => 'menu de tablero de informacion de balances y estadisticas en el sistema'])->syncRoles([$super_admin, $administrator]);
        Permission::create(['name' => 'country-menu', 'description' => 'menu de configuracion de paises en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'raffle-menu', 'description' => 'menu de configuracion de sorteos en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'promotion-menu', 'description' => 'menu de configuracion de promociones de sorteos en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'slider-menu', 'description' => 'menu de configuracion de sliders en el app'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'sale-menu', 'description' => 'menu de configuracion de ventas en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'egress-menu', 'description' => 'menu de configuracion de egresos en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'withdrawal-menu', 'description' => 'menu de configuracion de solicitudes de retiros en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'report-menu', 'description' => 'menu de configuracion de reportes en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'notification-menu', 'description' => 'menu de configuracion de notificaciones en el sistema'])->syncRoles([$super_admin]);
        Permission::create(['name' => 'rewards-bonuses-menu', 'description' => 'menu de configuracion de bonos y recompensas en el sistema'])->syncRoles([$super_admin]);

        User::create([
            'names' => 'Super ',
            'surnames' => 'Admin',
            'email' => 'super-admin@jimbosorteos.com',
            'password' => Hash::make('admin'),
        ])->assignRole($super_admin);
    }
}
