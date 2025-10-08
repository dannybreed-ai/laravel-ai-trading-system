<?php

use App\Models\Bot;
use App\Models\BotActivation;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    // Get authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Bot endpoints
    Route::prefix('bots')->group(function () {
        Route::get('/', function () {
            return Bot::active()->get();
        });

        Route::get('/{id}', function ($id) {
            return Bot::findOrFail($id);
        });
    });

    // Bot activations endpoints
    Route::prefix('activations')->group(function () {
        Route::get('/', function (Request $request) {
            return $request->user()
                ->botActivations()
                ->with('bot')
                ->latest()
                ->paginate(20);
        });

        Route::get('/{id}', function (Request $request, $id) {
            return $request->user()
                ->botActivations()
                ->with('bot')
                ->findOrFail($id);
        });

        // Get activation status (for polling)
        Route::get('/{id}/status', function (Request $request, $id) {
            $activation = $request->user()
                ->botActivations()
                ->findOrFail($id);

            return [
                'id' => $activation->id,
                'status' => $activation->status,
                'current_profit' => $activation->current_profit,
                'investment_amount' => $activation->investment_amount,
            ];
        });
    });

    // Trades endpoints
    Route::prefix('trades')->group(function () {
        Route::get('/', function (Request $request) {
            return $request->user()
                ->trades()
                ->with('botActivation')
                ->latest()
                ->paginate(20);
        });
    });

    // Stats endpoint
    Route::get('/stats', function (Request $request) {
        $user = $request->user();

        return [
            'balance' => $user->balance,
            'total_profit' => $user->total_profit,
            'active_bots' => $user->botActivations()->where('status', 'active')->count(),
            'total_trades' => $user->trades()->count(),
            'referral_earnings' => $user->referralEarnings()->sum('amount'),
        ];
    });
});
