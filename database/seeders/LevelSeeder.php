<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    private $table = 'levels';
    private $items = [
        [
            'name'      => 'classic',
            'active'     => 1,
        ],
        [
            'name'      => 'junior',
            'active'     => 1,
        ],
        [
            'name'      => 'middle',
            'active'     => 1,
        ],
        [
            'name'      => 'master',
            'active'     => 1,
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
