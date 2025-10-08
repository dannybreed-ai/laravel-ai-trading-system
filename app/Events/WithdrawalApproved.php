<?php

namespace App\Events;

use App\Models\Withdrawal;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WithdrawalApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $withdrawal;
    public $timestamp;

    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
        $this->timestamp = now();
    }
}
