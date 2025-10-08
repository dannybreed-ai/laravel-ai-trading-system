<?php

namespace Database\Seeders;

use App\Models\Bot;
use App\Models\BotActivation;
use App\Models\Deposit;
use App\Models\ReferralEarning;
use App\Models\Trade;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $demoUser = User::where('email', 'demo@stockandfi.com')->first();
        $testUser = User::where('email', 'test@stockandfi.com')->first();

        if (!$demoUser || !$testUser) {
            $this->command->warn('Users not found. Run UserSeeder first.');
            return;
        }

        // Create referral chain
        $users = [$demoUser, $testUser];
        $level1User = User::firstOrCreate(
            ['email' => 'level1@example.com'],
            [
                'name' => 'Level 1 User',
                'username' => 'level1',
                'password' => bcrypt('password'),
                'referred_by' => $demoUser->id,
                'balance' => 1000.00,
                'status' => true,
            ]
        );

        $level2User = User::firstOrCreate(
            ['email' => 'level2@example.com'],
            [
                'name' => 'Level 2 User',
                'username' => 'level2',
                'password' => bcrypt('password'),
                'referred_by' => $level1User->id,
                'balance' => 750.00,
                'status' => true,
            ]
        );

        $level3User = User::firstOrCreate(
            ['email' => 'level3@example.com'],
            [
                'name' => 'Level 3 User',
                'username' => 'level3',
                'password' => bcrypt('password'),
                'referred_by' => $level2User->id,
                'balance' => 500.00,
                'status' => true,
            ]
        );

        // Create bot activations
        $bots = Bot::all();
        if ($bots->isNotEmpty()) {
            $bot = $bots->first();

            // Active activation for demo user
            $activation = BotActivation::firstOrCreate(
                [
                    'user_id' => $demoUser->id,
                    'bot_id' => $bot->id,
                    'status' => 'active',
                ],
                [
                    'investment_amount' => 1000.00,
                    'current_profit' => 45.50,
                    'activated_at' => now()->subDays(5),
                ]
            );

            // Create sample trades for the activation
            for ($i = 0; $i < 5; $i++) {
                Trade::firstOrCreate(
                    [
                        'user_id' => $demoUser->id,
                        'bot_activation_id' => $activation->id,
                    ],
                    [
                        'symbol' => $bot->symbol,
                        'side' => $i % 2 === 0 ? 'buy' : 'sell',
                        'quantity' => rand(10, 100) / 100,
                        'price' => rand(30000, 35000),
                        'total' => rand(300, 500),
                        'fee' => rand(1, 5),
                        'profit_loss' => rand(5, 20),
                        'status' => 'completed',
                        'created_at' => now()->subDays(rand(1, 5)),
                    ]
                );
            }

            // Closed activation
            BotActivation::firstOrCreate(
                [
                    'user_id' => $testUser->id,
                    'bot_id' => $bot->id,
                    'status' => 'closed',
                ],
                [
                    'investment_amount' => 500.00,
                    'current_profit' => 25.00,
                    'final_profit' => 25.00,
                    'activated_at' => now()->subDays(20),
                    'closed_at' => now()->subDays(10),
                ]
            );
        }

        // Create deposits
        Deposit::firstOrCreate(
            [
                'user_id' => $demoUser->id,
                'status' => 'approved',
            ],
            [
                'amount' => 1000.00,
                'network' => 'USDT-TRC20',
                'transaction_hash' => Str::random(64),
                'approved_at' => now()->subDays(10),
                'approved_by' => User::where('is_admin', true)->first()->id,
            ]
        );

        // Create withdrawals
        Withdrawal::firstOrCreate(
            [
                'user_id' => $testUser->id,
                'status' => 'approved',
            ],
            [
                'amount' => 200.00,
                'network' => 'BTC',
                'wallet_address' => 'bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh',
                'transaction_hash' => Str::random(64),
                'approved_at' => now()->subDays(5),
                'approved_by' => User::where('is_admin', true)->first()->id,
            ]
        );

        // Create referral earnings
        ReferralEarning::firstOrCreate(
            [
                'user_id' => $demoUser->id,
                'referred_user_id' => $level1User->id,
            ],
            [
                'level' => 1,
                'amount' => 50.00,
                'source_type' => 'deposit',
                'source_id' => 1,
                'commission_rate' => 5.00,
            ]
        );

        // Create transactions
        Transaction::firstOrCreate(
            [
                'user_id' => $demoUser->id,
                'reference' => 'DEP-' . strtoupper(Str::random(10)),
            ],
            [
                'type' => 'deposit',
                'amount' => 1000.00,
                'balance_after' => $demoUser->balance,
                'description' => 'Deposit approved',
                'status' => 'completed',
            ]
        );

        $this->command->info('Sample data created successfully!');
    }
}
