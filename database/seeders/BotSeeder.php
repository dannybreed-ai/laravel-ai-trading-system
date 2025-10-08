<?php

namespace Database\Seeders;

use App\Models\Bot;
use Illuminate\Database\Seeder;

class BotSeeder extends Seeder
{
    public function run(): void
    {
        $bots = [
            [
                'name' => 'Conservative BTC Bot',
                'symbol' => 'BTC/USDT',
                'description' => 'Low-risk Bitcoin trading bot with conservative strategies',
                'min_investment' => 100.00,
                'max_investment' => 5000.00,
                'expected_return_min' => 1.00,
                'expected_return_max' => 3.00,
                'duration_days' => 30,
                'risk_level' => 'low',
                'risk_weight' => 0.50,
                'status' => 'active',
            ],
            [
                'name' => 'Balanced ETH Bot',
                'symbol' => 'ETH/USDT',
                'description' => 'Medium-risk Ethereum trading bot with balanced approach',
                'min_investment' => 200.00,
                'max_investment' => 10000.00,
                'expected_return_min' => 2.00,
                'expected_return_max' => 5.00,
                'duration_days' => 30,
                'risk_level' => 'medium',
                'risk_weight' => 1.00,
                'status' => 'active',
            ],
            [
                'name' => 'Aggressive Multi-Coin Bot',
                'symbol' => 'MULTI',
                'description' => 'High-risk bot trading multiple cryptocurrencies',
                'min_investment' => 500.00,
                'max_investment' => 20000.00,
                'expected_return_min' => 5.00,
                'expected_return_max' => 15.00,
                'duration_days' => 30,
                'risk_level' => 'high',
                'risk_weight' => 1.50,
                'status' => 'active',
            ],
            [
                'name' => 'BNB Smart Chain Bot',
                'symbol' => 'BNB/USDT',
                'description' => 'Medium-risk bot focused on Binance Coin',
                'min_investment' => 150.00,
                'max_investment' => 7500.00,
                'expected_return_min' => 2.50,
                'expected_return_max' => 6.00,
                'duration_days' => 30,
                'risk_level' => 'medium',
                'risk_weight' => 1.00,
                'status' => 'active',
            ],
            [
                'name' => 'Altcoin Hunter Bot',
                'symbol' => 'ALT',
                'description' => 'Very high-risk bot targeting emerging altcoins',
                'min_investment' => 1000.00,
                'max_investment' => 50000.00,
                'expected_return_min' => 10.00,
                'expected_return_max' => 30.00,
                'duration_days' => 30,
                'risk_level' => 'very_high',
                'risk_weight' => 2.00,
                'status' => 'active',
            ],
        ];

        foreach ($bots as $bot) {
            Bot::firstOrCreate(
                ['name' => $bot['name']],
                $bot
            );
        }
    }
}
