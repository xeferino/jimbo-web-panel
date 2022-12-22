<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    private $table = 'settings';
    private $items = [
        [
            'name'      => 'jib_usd',
            'value'     => '0.10',
        ],
        [
            'name'      => 'jib_unit_x_usd',
            'value'     => '1',
        ],
        [
            'name'      => 'register',
            'value'  => '500',
        ],
        [
            'name'      => 'referrals',
            'value'  => '100',
        ],
        [
            'name'      => 'to_access',
            'value'  => '100',
        ],

        //niveles de vendedores metas individuales
        [
            'name'      => 'level_single_junior',
            'value'  => '500',
        ],
        [
            'name'      => 'level_single_middle',
            'value'  => '1500',
        ],
        [
            'name'      => 'level_single_master',
            'value'  => '2500',
        ],

        //porcentaje de niveles
        [
            'name'      => 'level_percent_single_junior',
            'value'  => '8',
        ],
        [
            'name'      => 'level_percent_single_middle',
            'value'  => '10',
        ],
        [
            'name'      => 'level_percent_single_master',
            'value'  => '12',
        ],

        //bono unico de niveles
        [
            'name'      => 'level_ascent_bonus_single_junior',
            'value'  => '10',
        ],
        [
            'name'      => 'level_ascent_bonus_single_middle',
            'value'  => '20',
        ],
        [
            'name'      => 'level_ascent_bonus_single_master',
            'value'  => '50',
        ],

        //bono unico de vendedor clasico
        [
            'name'      => 'level_classic_ascent_unique_bonus',
            'value'  => '10',
        ],


        //POR CONVERTIRCE EN VENDEDOR
        [
            'name'      => 'user_to_seller',
            'value'  => '50',
        ],

        //POR CONVERTIRCE EN VENDEDOR X UNICA VEZ  + 1 VENTA MIN. GANA
        [
            'name'      => 'level_classic_seller_percent',
            'value'  => '50',
        ],

        //X REGISTRAR UN VENDEDOR CON TU   ID  (+VENTA MIN. 1$ USD)
        [
            'name'      => 'level_classic_referral_bonus',
            'value'  => '1',
        ],

        //POR TOTAS TUS VENTAS NETAS GANA EL 5% DE COMISIONES
        [
            'name'      => 'level_classic_sale_percent',
            'value'  => '5',
        ],

        //niveles de metas vendedores grupales
        [
            'name'      => 'level_group_junior',
            'value'  => '500',
        ],
        [
            'name'      => 'level_group_middle',
            'value'  => '1500',
        ],
        [
            'name'      => 'level_group_master',
            'value'  => '2500',
        ],

        //porcentaje de niveles grupales
        [
            'name'      => 'level_percent_group_junior',
            'value'  => '8',
        ],
        [
            'name'      => 'level_percent_group_middle',
            'value'  => '10',
        ],
        [
            'name'      => 'level_percent_group_master',
            'value'  => '12',
        ],

        //porcentaje de niveles grupales referrals
        /* [
            'name'      => 'level_percent_group_referral_junior',
            'value'  => '8',
        ],
        [
            'name'      => 'level_percent_group_referral_middle',
            'value'  => '10',
        ],
        [
            'name'      => 'level_percent_group_referral_master',
            'value'  => '12',
        ], */

        //TERMINOS Y CONDICIONES
        [
            'name'      => 'terms_and_conditions',
            'value'  => 'text',
        ],

        //politicas de privacidad
        [
            'name'      => 'policies_privacy',
            'value'  => 'text',
        ],

        //reglas del juego
        [
            'name'      => 'game_rules',
            'value'  => 'text',
        ],

        //preguntas frecuentes
        [
            'name'      => 'faqs',
            'value'  => 'text',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->items as $item)
        {
            DB::table($this->table)->insert($item);
        }
    }
}
