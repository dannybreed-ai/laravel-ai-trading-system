<?php

namespace App\Listeners;

use App\Events\BotClosed;
use Illuminate\Support\Facades\Log;

class LogBotClosed
{
    public function handle(BotClosed $event): void
    {
        Log::info('Bot closed', [
            'user_id' => $event->botActivation->user_id,
            'bot_id' => $event->botActivation->bot_id,
            'activation_id' => $event->botActivation->id,
            'final_profit' => $event->botActivation->final_profit,
            'timestamp' => $event->timestamp,
        ]);
    }
}
