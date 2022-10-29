<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    private $table = 'payment_methods';
    private $items = [
        [
            'name'     => 'jib',
            'valid'    => 1,
            'icon'     => 'jib.jpeg',
            'type'     => 'jib',
        ],
        [
            'name'     => 'plin',
            'valid'    => 0,
            'icon'     => 'plin.jpeg',
            'type'     => 'plin',
        ],
        [
            'name'     => 'yape',
            'valid'    => 0,
            'icon'     => 'yape.jpeg',
            'type'     => 'yape',
        ],
        [
            'name'     => 'card',
            'valid'    => 1,
            'icon'     => 'card.jpeg',
            'type'     => 'card',
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
