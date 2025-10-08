<?php

namespace App\Listeners;

use App\Events\BotActivated;
use Illuminate\Support\Facades\Log;

class LogBotActivation
{
    public function handle(BotActivated $event): void
    {
        Log::info('Bot activated', [
            'activation_id' => $event->activation->id,
            'user_id' => $event->activation->user_id,
            'bot_id' => $event->activation->bot_id,
            'amount' => $event->activation->investment_amount,
        ]);
    }
}
