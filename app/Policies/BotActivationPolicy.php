<?php

namespace App\Policies;

use App\Models\BotActivation;
use App\Models\User;

class BotActivationPolicy
{
    public function view(User $user, BotActivation $activation): bool
    {
        return $user->id === $activation->user_id || $user->is_admin;
    }

    public function close(User $user, BotActivation $activation): bool
    {
        return $user->id === $activation->user_id && $activation->status === 'active';
    }
}
