<?php

namespace App\Policies;

use App\Models\Deposit;
use App\Models\User;

class DepositPolicy
{
    /**
     * Determine if the user can view the deposit.
     */
    public function view(User $user, Deposit $deposit): bool
    {
        return $user->isAdmin() || $user->id === $deposit->user_id;
    }

    /**
     * Determine if the user can update the deposit.
     */
    public function update(User $user, Deposit $deposit): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can approve/reject deposits.
     */
    public function manage(User $user): bool
    {
        return $user->isAdmin();
    }
}
