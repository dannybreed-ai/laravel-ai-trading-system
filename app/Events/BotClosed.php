<?php

namespace App\Events;

use App\Models\BotActivation;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BotClosed
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public BotActivation $activation
    ) {}
}
