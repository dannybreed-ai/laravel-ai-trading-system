<?php

return [
    'enabled' => env('REFERRAL_ENABLED', true),

    'levels' => [
        1 => 0.10,   // 10%
        2 => 0.05,   // 5%
        3 => 0.03,   // 3%
        4 => 0.02,   // 2%
        5 => 0.01,   // 1%
        6 => 0.01,   // 1%
        7 => 0.005,  // 0.5%
        8 => 0.005,  // 0.5%
        9 => 0.0025, // 0.25%
        10 => 0.0025, // 0.25%
    ],

    'max_levels' => 10,

    'bonus_on' => [
        'deposits' => true,
        'bot_profits' => true,
        'trading_fees' => false,
    ],

    'code_length' => 8,
    'code_prefix' => '',
];
