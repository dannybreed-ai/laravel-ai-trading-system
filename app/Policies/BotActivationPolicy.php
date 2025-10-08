<?php

namespace App\Policies;

use App\Models\BotActivation;
use App\Models\User;

class BotActivationPolicy
{
    /**
     * Determine if the user can view the bot activation.
     */
    public function view(User $user, BotActivation $botActivation): bool
    {
        return $user->isAdmin() || $user->id === $botActivation->user_id;
    }

    /**
     * Determine if the user can update/close the bot activation.
     */
    public function update(User $user, BotActivation $botActivation): bool
    {
        return $user->id === $botActivation->user_id;
    }

    /**
     * Determine if the user can view all bot activations.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
