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
                'name' => 'AI Scalper Pro',
                'description' => 'High-frequency trading bot for quick profits',
                'strategy_type' => 'Scalping',
                'min_investment' => 100,
                'max_investment' => 5000,
                'daily_profit_range_min' => 1.5,
                'daily_profit_range_max' => 3.5,
                'duration_days' => 30,
                'risk_level' => 'medium',
                'features' => ['24/7 Trading', 'Stop Loss', 'Take Profit'],
            ],
            [
                'name' => 'Trend Master',
                'description' => 'Long-term trend following strategy',
                'strategy_type' => 'Trend Following',
                'min_investment' => 500,
                'max_investment' => 10000,
                'daily_profit_range_min' => 0.8,
                'daily_profit_range_max' => 2.0,
                'duration_days' => 60,
                'risk_level' => 'low',
                'features' => ['Risk Management', 'Technical Analysis', 'Market Scanner'],
            ],
            [
                'name' => 'Arbitrage Hunter',
                'description' => 'Exploits price differences across exchanges',
                'strategy_type' => 'Arbitrage',
                'min_investment' => 1000,
                'max_investment' => 50000,
                'daily_profit_range_min' => 0.5,
                'daily_profit_range_max' => 1.5,
                'duration_days' => 90,
                'risk_level' => 'low',
                'features' => ['Multi-Exchange', 'Low Risk', 'Automated'],
            ],
            [
                'name' => 'Volatility Trader',
                'description' => 'Profits from market volatility',
                'strategy_type' => 'Volatility Trading',
                'min_investment' => 200,
                'max_investment' => 3000,
                'daily_profit_range_min' => 2.0,
                'daily_profit_range_max' => 5.0,
                'duration_days' => 30,
                'risk_level' => 'high',
                'features' => ['High Returns', 'Advanced AI', 'Real-time Analysis'],
            ],
        ];

        foreach ($bots as $bot) {
            Bot::create($bot);
        }
    }
}
