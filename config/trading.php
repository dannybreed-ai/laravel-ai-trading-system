<?php

return [
    'default_symbols' => [
        'BTC/USDT',
        'ETH/USDT',
        'BNB/USDT',
        'XRP/USDT',
        'ADA/USDT',
        'SOL/USDT',
        'DOGE/USDT',
        'DOT/USDT',
    ],

    'fee_rates' => [
        'trade_fee' => 0.001,        // 0.1%
        'withdrawal_fee' => 0.02,    // 2%
        'p2p_transfer_fee' => 0.01,  // 1%
    ],

    'max_concurrent_bots' => env('MAX_CONCURRENT_BOTS', 5),

    'profit_distribution' => [
        'min_daily_profit' => 0.5,   // 0.5%
        'max_daily_profit' => 5.0,   // 5%
        'default_duration_days' => 30,
    ],

    'limits' => [
        'min_investment' => 10,
        'max_investment' => 100000,
        'min_withdrawal' => 10,
        'max_withdrawal' => 100000,
        'min_deposit' => 1,
    ],

    'risk_levels' => [
        'low' => 'Low Risk',
        'medium' => 'Medium Risk',
        'high' => 'High Risk',
    ],
];
