<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $data = [
            'balance' => $user->balance,
            'active_bots_count' => $user->botActivations()->where('status', 'active')->count(),
            'total_profit' => $user->total_profit,
            'kyc_status' => $user->isKycVerified() ? 'verified' : 'pending',
            'recent_transactions' => Transaction::where('user_id', $user->id)
                ->latest()
                ->take(10)
                ->get(),
            'referral_earnings' => $user->referralEarnings()->sum('amount'),
            'active_bots' => $user->botActivations()
                ->with('bot')
                ->where('status', 'active')
                ->get(),
        ];

        return view('dashboard.user', compact('data'));
    }
}
