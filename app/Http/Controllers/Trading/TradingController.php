<?php

namespace App\Http\Controllers\Trading;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivateBotRequest;
use App\Models\Bot;
use App\Models\BotActivation;
use App\Models\Transaction;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TradingController extends Controller
{
    public function bots()
    {
        $bots = Bot::active()->get();
        $userActiveBots = auth()->user()->botActivations()->active()->count();

        return view('trading.bots.index', compact('bots', 'userActiveBots'));
    }

    public function activateBot(ActivateBotRequest $request, Bot $bot)
    {
        $user = auth()->user();

        if ($user->balance < $request->investment_amount) {
            return back()->with('error', 'Insufficient balance.');
        }

        if ($request->investment_amount < $bot->min_investment || $request->investment_amount > $bot->max_investment) {
            return back()->with('error', 'Investment amount outside allowed range.');
        }

        DB::beginTransaction();
        try {
            $balanceBefore = $user->balance;
            $user->decrement('balance', $request->investment_amount);
            $user->refresh();

            $activation = BotActivation::create([
                'user_id' => $user->id,
                'bot_id' => $bot->id,
                'investment_amount' => $request->investment_amount,
                'duration_days' => $bot->duration_days,
                'status' => 'active',
                'started_at' => now(),
                'expected_end_at' => now()->addDays($bot->duration_days),
                'profit_earned' => 0,
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'trade_fee',
                'amount' => $request->investment_amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->balance,
                'reference' => $activation->id,
                'reference_type' => 'bot_activation',
                'description' => "Bot activation: {$bot->name}",
            ]);

            $bot->increment('total_activations');

            DB::commit();

            return redirect()->route('trading.activations')
                ->with('success', 'Bot activated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to activate bot. Please try again.');
        }
    }

    public function activations()
    {
        $activations = auth()->user()->botActivations()
            ->with('bot')
            ->latest()
            ->paginate(15);

        return view('trading.activations.index', compact('activations'));
    }

    public function closeActivation(BotActivation $activation)
    {
        if ($activation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($activation->status !== 'active') {
            return back()->with('error', 'This activation is not active.');
        }

        DB::beginTransaction();
        try {
            $user = $activation->user;
            $totalReturn = $activation->investment_amount + $activation->profit_earned;
            
            $balanceBefore = $user->balance;
            $user->increment('balance', $totalReturn);
            $user->refresh();

            $activation->update([
                'status' => 'completed',
                'closed_at' => now(),
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'profit',
                'amount' => $totalReturn,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->balance,
                'reference' => $activation->id,
                'reference_type' => 'bot_activation',
                'description' => "Bot return: {$activation->bot->name}",
            ]);

            DB::commit();

            return back()->with('success', 'Bot activation closed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to close activation.');
        }
    }

    public function trades()
    {
        $trades = auth()->user()->trades()
            ->with('bot')
            ->latest()
            ->paginate(20);

        return view('trading.trades', compact('trades'));
    }
}
