<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Trading Symbols
    |--------------------------------------------------------------------------
    |
    | List of supported trading symbols for the AI bots.
    |
    */
    'symbols' => [
        'BTC/USDT',
        'ETH/USDT',
        'BNB/USDT',
        'SOL/USDT',
        'XRP/USDT',
        'ADA/USDT',
        'DOGE/USDT',
        'DOT/USDT',
        'MATIC/USDT',
        'AVAX/USDT',
    ],

    /*
    |--------------------------------------------------------------------------
    | Trading Fee Rates
    |--------------------------------------------------------------------------
    |
    | Default fee rates for maker and taker orders (in percentage).
    |
    */
    'fees' => [
        'maker' => env('TRADING_FEE_MAKER', 0.10),
        'taker' => env('TRADING_FEE_TAKER', 0.15),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maximum Concurrent Bots
    |--------------------------------------------------------------------------
    |
    | Maximum number of bots a single user can activate simultaneously.
    |
    */
    'max_concurrent_bots' => env('TRADING_MAX_CONCURRENT_BOTS', 5),

    /*
    |--------------------------------------------------------------------------
    | Profit Distribution
    |--------------------------------------------------------------------------
    |
    | How profits are distributed: user percentage and platform percentage.
    |
    */
    'profit_distribution' => [
        'user' => env('TRADING_PROFIT_USER_PERCENTAGE', 85.00),
        'platform' => env('TRADING_PROFIT_PLATFORM_PERCENTAGE', 15.00),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Risk Weights
    |--------------------------------------------------------------------------
    |
    | Default risk weights for different risk levels.
    |
    */
    'default_risk_weights' => [
        'low' => env('TRADING_RISK_WEIGHT_LOW', 0.50),
        'medium' => env('TRADING_RISK_WEIGHT_MEDIUM', 1.00),
        'high' => env('TRADING_RISK_WEIGHT_HIGH', 1.50),
        'very_high' => env('TRADING_RISK_WEIGHT_VERY_HIGH', 2.00),
    ],

    /*
    |--------------------------------------------------------------------------
    | Trading Bot Settings
    |--------------------------------------------------------------------------
    |
    | General settings for trading bots.
    |
    */
    'bot_settings' => [
        'min_investment' => env('TRADING_MIN_INVESTMENT', 100.00),
        'max_investment' => env('TRADING_MAX_INVESTMENT', 10000.00),
        'default_duration_days' => env('TRADING_DEFAULT_DURATION', 30),
    ],
];
