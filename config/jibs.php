<?php
$jib_unit = 1000;
$jib_usd  = 0.10;


return [

    /*
    |--------------------------------------------------------------------------
    | Jibs change app
    |--------------------------------------------------------------------------
    |
    |
    */

    //change
    'quantity' => [
        '10000'     => (10000/$jib_unit)*$jib_usd, // 1 usd
        '50000'     => (50000/$jib_unit)*$jib_usd, // 5 usd
        '100000'    => (100000/$jib_unit)*$jib_usd, // 10 usd
        '150000'    => (150000/$jib_unit)*$jib_usd, // 15 usd
    ],

    'bonus' => [
        'register'      => 3500,
        'referrals'     => 100,
        'to_access'     => 100,
    ]
];
