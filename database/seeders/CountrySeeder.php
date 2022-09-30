<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    private $table = 'countries';
    private $items = [
        [
            'name' => 'Peru',
            'code' => '+511',
            'img'  => 'flag.png'
        ],
        [
            'name' => 'Ecuador',
            'code' => '+566',
            'img'  => 'flag.png'
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
