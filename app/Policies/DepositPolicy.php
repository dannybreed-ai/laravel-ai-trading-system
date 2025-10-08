<?php

namespace App\Policies;

use App\Models\Deposit;
use App\Models\User;

class DepositPolicy
{
    public function view(User $user, Deposit $deposit): bool
    {
        return $user->id === $deposit->user_id || $user->is_admin;
    }

    public function approve(User $user, Deposit $deposit): bool
    {
        return $user->is_admin;
    }

    public function reject(User $user, Deposit $deposit): bool
    {
        return $user->is_admin;
    }
}
