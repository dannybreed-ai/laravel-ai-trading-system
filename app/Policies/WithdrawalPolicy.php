<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Withdrawal;

class WithdrawalPolicy
{
    /**
     * Determine if the user can view the withdrawal.
     */
    public function view(User $user, Withdrawal $withdrawal): bool
    {
        return $user->isAdmin() || $user->id === $withdrawal->user_id;
    }

    /**
     * Determine if the user can update the withdrawal.
     */
    public function update(User $user, Withdrawal $withdrawal): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can approve/reject withdrawals.
     */
    public function manage(User $user): bool
    {
        return $user->isAdmin();
    }
}
