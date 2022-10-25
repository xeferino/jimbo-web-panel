<?php
$jib_unit = 1;
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
        '10'     => (10/$jib_unit)*$jib_usd, // 1 usd
        '50'     => (50/$jib_unit)*$jib_usd, // 5 usd
        '100'    => (100/$jib_unit)*$jib_usd, // 10 usd
        '150'    => (150/$jib_unit)*$jib_usd, // 15 usd
    ],

    'bonus' => [
        'register'      => 35,
        'referrals'     => 10,
        'to_access'     => 10,
    ]
];
