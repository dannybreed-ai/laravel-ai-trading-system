<?php

namespace App\Console\Commands;

use App\Models\BotActivation;
use App\Models\Trade;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SimulateBotProfit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:simulate-profit {--dry-run : Run without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate profit generation for active bot activations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->info('Running in DRY RUN mode - no changes will be made');
        }

        $activations = BotActivation::with(['bot', 'user'])
            ->where('status', 'active')
            ->get();

        if ($activations->isEmpty()) {
            $this->warn('No active bot activations found.');
            return 0;
        }

        $this->info("Found {$activations->count()} active bot activations");

        foreach ($activations as $activation) {
            $this->processActivation($activation, $dryRun);
        }

        $this->info('Profit simulation completed!');
        return 0;
    }

    /**
     * Process a single bot activation
     */
    private function processActivation(BotActivation $activation, bool $dryRun): void
    {
        $bot = $activation->bot;
        $user = $activation->user;

        // Generate random profit based on bot's expected returns
        $profitPercentage = rand(
            (int)($bot->expected_return_min * 100),
            (int)($bot->expected_return_max * 100)
        ) / 10000; // Convert to decimal

        $profitAmount = $activation->investment_amount * $profitPercentage * $bot->risk_weight;

        // Random number of trades (1-5)
        $numTrades = rand(1, 5);

        $this->line("Processing activation #{$activation->id} for {$user->name}");
        $this->line("  Bot: {$bot->name}");
        $this->line("  Investment: \${$activation->investment_amount}");
        $this->line("  Generating {$numTrades} trades with profit: \${$profitAmount}");

        if ($dryRun) {
            $this->info("  [DRY RUN] Would generate {$numTrades} trades and update profit");
            return;
        }

        DB::transaction(function () use ($activation, $bot, $user, $numTrades, $profitAmount) {
            // Generate trades
            $profitPerTrade = $profitAmount / $numTrades;
            
            for ($i = 0; $i < $numTrades; $i++) {
                $side = $i % 2 === 0 ? 'buy' : 'sell';
                $quantity = rand(10, 100) / 100;
                $price = rand(20000, 40000);
                $total = $quantity * $price;

                Trade::create([
                    'user_id' => $user->id,
                    'bot_activation_id' => $activation->id,
                    'symbol' => $bot->symbol,
                    'side' => $side,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $total,
                    'fee' => $total * 0.001, // 0.1% fee
                    'profit_loss' => $profitPerTrade,
                    'status' => 'completed',
                ]);
            }

            // Update activation profit
            $activation->increment('current_profit', $profitAmount);

            Log::info('Bot profit simulated', [
                'activation_id' => $activation->id,
                'user_id' => $user->id,
                'profit_amount' => $profitAmount,
                'trades_generated' => $numTrades,
            ]);
        });

        $this->info("  ✓ Generated {$numTrades} trades and updated profit");
    }
}
