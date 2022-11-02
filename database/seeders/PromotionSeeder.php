<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionSeeder extends Seeder
{
    private $table = 'promotions';
    private $items = [
        [
            'name'       => '1 boleto por 1$',
            'code'       => time(),
            'price'      => 1,
            'quantity'   => 1,
            'active'     => 1,
            'created_at' => now(),
            'deleted_at' => now(),
        ],

        [
            'name'       => '7 Boletos por 5$',
            'code'       => time(),
            'price'      => 5,
            'quantity'   => 7,
            'active'     => 1,
            'created_at' => now(),
            'deleted_at' => now(),
        ],

        [
            'name'       => '15 Boletos por 10$',
            'code'       => time(),
            'price'      => 10,
            'quantity'   => 15,
            'active'     => 1,
            'created_at' => now(),
            'deleted_at' => now(),
        ],

        [
            'name'       => '30 Boletos por 20$',
            'code'       => time(),
            'price'      => 20,
            'quantity'   => 30,
            'active'     => 1,
            'created_at' => now(),
            'deleted_at' => now(),
        ],

        [
            'name'       => '75 Boletos por 50$',
            'code'       => time(),
            'price'      => 50,
            'quantity'   => 75,
            'active'     => 1,
            'created_at' => now(),
            'deleted_at' => now(),
        ],

        [
            'name'       => '175 Boletos por 100$',
            'code'       => time(),
            'price'      => 100,
            'quantity'   => 175,
            'active'     => 1,
            'created_at' => now(),
            'deleted_at' => now(),
        ],

        [
            'name'       => '300 Boletos por 150$',
            'code'       => time(),
            'price'      => 150,
            'quantity'   => 300,
            'active'     => 1,
            'created_at' => now(),
            'deleted_at' => now(),
        ]
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
