<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BotActivation;
use App\Models\Deposit;
use App\Models\KycRecord;
use App\Models\Trade;
use App\Models\User;
use App\Models\Withdrawal;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'total_users' => User::count(),
            'kyc_pending' => KycRecord::pending()->count(),
            'active_bots' => BotActivation::active()->count(),
            'total_volume_traded' => Trade::sum('total'),
            'total_deposits' => Deposit::approved()->sum('amount'),
            'total_withdrawals' => Withdrawal::approved()->sum('amount'),
        ];

        $recentData = [
            'users' => User::latest()->take(10)->get(),
            'deposits' => Deposit::with('user')->latest()->take(10)->get(),
            'withdrawals' => Withdrawal::with('user')->latest()->take(10)->get(),
            'kyc_requests' => KycRecord::with('user')->pending()->latest()->take(10)->get(),
            'activations' => BotActivation::with(['user', 'bot'])->latest()->take(10)->get(),
        ];

        return view('dashboard.admin', compact('metrics', 'recentData'));
    }
}
