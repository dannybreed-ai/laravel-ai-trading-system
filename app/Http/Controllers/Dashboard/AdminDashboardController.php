<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bot;
use App\Models\BotActivation;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\Trade;
use App\Models\KycRecord;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::active()->count(),
            'kyc_verified_users' => User::kycVerified()->count(),
            'total_bots' => Bot::count(),
            'active_bot_activations' => BotActivation::active()->count(),
            'total_volume' => BotActivation::sum('investment_amount'),
            'total_profit_generated' => BotActivation::sum('profit_earned'),
            'pending_deposits' => Deposit::pending()->count(),
            'pending_withdrawals' => Withdrawal::pending()->count(),
            'pending_kyc' => KycRecord::pending()->count(),
        ];

        $recentDeposits = Deposit::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentWithdrawals = Withdrawal::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentActivations = BotActivation::with(['user', 'bot'])
            ->latest()
            ->take(10)
            ->get();

        $pendingKyc = KycRecord::with('user')
            ->pending()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'recentDeposits', 'recentWithdrawals', 'recentActivations', 'pendingKyc'));
    }
}
