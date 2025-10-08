<?php

namespace App\Listeners;

use App\Events\BotActivated;
use Illuminate\Support\Facades\Log;

class LogBotActivated
{
    public function handle(BotActivated $event): void
    {
        Log::info('Bot activated', [
            'user_id' => $event->botActivation->user_id,
            'bot_id' => $event->botActivation->bot_id,
            'activation_id' => $event->botActivation->id,
            'investment_amount' => $event->botActivation->investment_amount,
            'timestamp' => $event->timestamp,
        ]);
    }
}
