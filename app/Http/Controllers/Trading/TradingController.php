<?php

namespace App\Http\Controllers\Trading;

use App\Events\BotActivated;
use App\Events\BotClosed;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivateBotRequest;
use App\Models\Bot;
use App\Models\BotActivation;
use App\Models\Trade;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TradingController extends Controller
{
    public function index()
    {
        $bots = Bot::active()->get();
        return view('trading.bots.index', compact('bots'));
    }

    public function activations()
    {
        $activations = auth()->user()
            ->botActivations()
            ->with('bot')
            ->latest()
            ->paginate(20);

        return view('trading.activations.index', compact('activations'));
    }

    public function activate(ActivateBotRequest $request)
    {
        $user = auth()->user();
        $bot = Bot::findOrFail($request->bot_id);

        // Validate investment amount against bot limits
        if ($request->investment_amount < $bot->min_investment || 
            $request->investment_amount > $bot->max_investment) {
            return back()->with('error', 'Investment amount must be between ' . 
                $bot->min_investment . ' and ' . $bot->max_investment);
        }

        // Check user balance
        if ($user->balance < $request->investment_amount) {
            return back()->with('error', 'Insufficient balance.');
        }

        // Check concurrent bots limit
        $activeBots = $user->botActivations()->where('status', 'active')->count();
        if ($activeBots >= config('trading.max_concurrent_bots')) {
            return back()->with('error', 'Maximum concurrent bots limit reached.');
        }

        DB::transaction(function () use ($user, $bot, $request, &$activation) {
            // Deduct balance
            $user->decrement('balance', $request->investment_amount);

            // Create activation
            $activation = BotActivation::create([
                'user_id' => $user->id,
                'bot_id' => $bot->id,
                'investment_amount' => $request->investment_amount,
                'status' => 'active',
                'activated_at' => now(),
            ]);

            // Record transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'bot_activation',
                'amount' => -$request->investment_amount,
                'balance_after' => $user->fresh()->balance,
                'reference' => 'BOT-' . strtoupper(Str::random(10)),
                'description' => 'Bot activation: ' . $bot->name,
                'status' => 'completed',
            ]);

            event(new BotActivated($activation));
        });

        return redirect()->route('trading.activations')
            ->with('success', 'Bot activated successfully!');
    }

    public function close($id)
    {
        $activation = BotActivation::where('user_id', auth()->id())
            ->where('id', $id)
            ->where('status', 'active')
            ->firstOrFail();

        DB::transaction(function () use ($activation) {
            $user = $activation->user;

            // Calculate final profit (for now, use current_profit)
            $finalAmount = $activation->investment_amount + $activation->current_profit;

            // Update activation
            $activation->update([
                'status' => 'closed',
                'closed_at' => now(),
                'final_profit' => $activation->current_profit,
            ]);

            // Return funds to user
            $user->increment('balance', $finalAmount);

            // Record transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'bot_closure',
                'amount' => $finalAmount,
                'balance_after' => $user->fresh()->balance,
                'reference' => 'CLOSE-' . strtoupper(Str::random(10)),
                'description' => 'Bot closure with profit',
                'status' => 'completed',
            ]);

            event(new BotClosed($activation));
        });

        return back()->with('success', 'Bot closed successfully!');
    }

    public function tradeHistory()
    {
        $trades = auth()->user()
            ->trades()
            ->with('botActivation.bot')
            ->latest()
            ->paginate(20);

        return view('trading.history', compact('trades'));
    }
}
