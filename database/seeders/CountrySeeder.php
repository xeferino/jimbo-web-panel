<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    private $table = 'countries';
    private $items = [
        [
            'name'      => 'Peru',
            'code'      => '+51',
            'iso'       => 'PE',
            'currency'  => 'SOL',
            'img'       => 'flag.png'
        ],
        [
            'name'      => 'Ecuador',
            'currency'  => 'USD',
            'code'      => '+56',
            'iso'       => 'ECU',
            'img'       => 'flag.png'
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
