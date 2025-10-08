<?php

namespace App\Http\Controllers\Referral;

use App\Http\Controllers\Controller;
use App\Models\User;

class ReferralController extends Controller
{
    public function tree()
    {
        $user = auth()->user();
        $referrals = $this->getReferralTree($user, 1, config('referral.max_depth'));

        return view('referral.tree', compact('user', 'referrals'));
    }

    public function earnings()
    {
        $user = auth()->user();

        $earningsByLevel = $user->referralEarnings()
            ->selectRaw('level, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('level')
            ->orderBy('level')
            ->get();

        $totalEarnings = $user->referralEarnings()->sum('amount');

        $recentEarnings = $user->referralEarnings()
            ->with('referredUser')
            ->latest()
            ->take(20)
            ->get();

        return view('referral.earnings', compact('earningsByLevel', 'totalEarnings', 'recentEarnings'));
    }

    /**
     * Get referral tree recursively
     */
    private function getReferralTree(User $user, int $currentLevel, int $maxDepth)
    {
        if ($currentLevel > $maxDepth) {
            return [];
        }

        $referrals = User::where('referred_by', $user->id)
            ->with(['referralEarnings' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get();

        $tree = [];
        foreach ($referrals as $referral) {
            $tree[] = [
                'user' => $referral,
                'level' => $currentLevel,
                'children' => $this->getReferralTree($referral, $currentLevel + 1, $maxDepth),
            ];
        }

        return $tree;
    }
}
