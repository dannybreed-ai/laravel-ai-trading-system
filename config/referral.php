<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Referral Commission Levels
    |--------------------------------------------------------------------------
    |
    | This array defines the commission rates for each referral level.
    | Level 1 is the direct referral, Level 2 is their referral, and so on.
    | Values are percentages (e.g., 5.00 = 5%).
    |
    */
    'levels' => [
        1 => env('REFERRAL_LEVEL_1', 5.00),
        2 => env('REFERRAL_LEVEL_2', 3.00),
        3 => env('REFERRAL_LEVEL_3', 2.00),
        4 => env('REFERRAL_LEVEL_4', 1.50),
        5 => env('REFERRAL_LEVEL_5', 1.00),
        6 => env('REFERRAL_LEVEL_6', 0.75),
        7 => env('REFERRAL_LEVEL_7', 0.50),
        8 => env('REFERRAL_LEVEL_8', 0.25),
        9 => env('REFERRAL_LEVEL_9', 0.15),
        10 => env('REFERRAL_LEVEL_10', 0.10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maximum Referral Depth
    |--------------------------------------------------------------------------
    |
    | Maximum number of levels to traverse when calculating referral earnings.
    |
    */
    'max_depth' => env('REFERRAL_MAX_DEPTH', 10),

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable Referral System
    |--------------------------------------------------------------------------
    |
    | Toggle the entire referral system on or off.
    |
    */
    'enabled' => env('REFERRAL_ENABLED', true),
];
