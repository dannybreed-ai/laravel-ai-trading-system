<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'balance' => $user->balance,
            'total_profit' => $user->total_profit,
            'total_deposits' => $user->total_deposits,
            'total_withdrawals' => $user->total_withdrawals,
            'active_bots' => $user->active_bot_activations,
        ];

        $activeBots = $user->botActivations()
            ->with('bot')
            ->where('status', 'active')
            ->latest()
            ->take(5)
            ->get();

        $recentTransactions = $user->transactions()
            ->latest()
            ->take(10)
            ->get();

        $referralStats = [
            'total_referrals' => $user->referrals()->count(),
            'total_earnings' => $user->referralEarnings()->sum('amount'),
            'this_month_earnings' => $user->referralEarnings()
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
        ];

        return view('dashboard.user', compact('stats', 'activeBots', 'recentTransactions', 'referralStats'));
    }
}
