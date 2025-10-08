<?php

namespace App\Events;

use App\Models\Deposit;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DepositApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $deposit;
    public $timestamp;

    public function __construct(Deposit $deposit)
    {
        $this->deposit = $deposit;
        $this->timestamp = now();
    }
}
