<?php

namespace App\Http\Controllers\Referral;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function tree()
    {
        $user = auth()->user();
        $referrals = $user->referrals()->with('referrals')->get();

        return view('referral.tree', compact('user', 'referrals'));
    }

    public function earnings()
    {
        $user = auth()->user();
        
        $stats = [
            'total_earnings' => $user->referralEarnings()->sum('amount'),
            'total_referrals' => $user->referrals()->count(),
            'this_month_earnings' => $user->referralEarnings()
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
        ];

        $earnings = $user->referralEarnings()
            ->with('fromUser')
            ->latest()
            ->paginate(20);

        $earningsByLevel = $user->referralEarnings()
            ->selectRaw('level, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('level')
            ->orderBy('level')
            ->get();

        return view('referral.earnings', compact('stats', 'earnings', 'earningsByLevel'));
    }
}
