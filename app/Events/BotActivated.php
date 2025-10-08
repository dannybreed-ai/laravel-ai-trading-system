<?php

namespace App\Events;

use App\Models\BotActivation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BotActivated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $botActivation;
    public $timestamp;

    public function __construct(BotActivation $botActivation)
    {
        $this->botActivation = $botActivation;
        $this->timestamp = now();
    }
}
