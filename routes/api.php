<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Bot;
use App\Models\BotActivation;
use App\Models\Trade;
use App\Models\Transaction;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/bots', function () {
        return Bot::active()->get();
    });

    Route::get('/activations', function (Request $request) {
        return $request->user()->botActivations()
            ->with('bot')
            ->latest()
            ->paginate(15);
    });

    Route::get('/trades', function (Request $request) {
        return $request->user()->trades()
            ->with('bot')
            ->latest()
            ->paginate(20);
    });

    Route::get('/transactions', function (Request $request) {
        return $request->user()->transactions()
            ->latest()
            ->paginate(20);
    });

    Route::get('/stats', function (Request $request) {
        $user = $request->user();
        return [
            'balance' => $user->balance,
            'total_profit' => $user->total_profit,
            'total_deposits' => $user->total_deposits,
            'total_withdrawals' => $user->total_withdrawals,
            'active_bots' => $user->active_bot_activations,
        ];
    });
});
