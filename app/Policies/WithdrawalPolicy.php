<?php

namespace App\Policies;

use App\Models\Withdrawal;
use App\Models\User;

class WithdrawalPolicy
{
    public function view(User $user, Withdrawal $withdrawal): bool
    {
        return $user->id === $withdrawal->user_id || $user->is_admin;
    }

    public function approve(User $user, Withdrawal $withdrawal): bool
    {
        return $user->is_admin;
    }

    public function reject(User $user, Withdrawal $withdrawal): bool
    {
        return $user->is_admin;
    }
}
