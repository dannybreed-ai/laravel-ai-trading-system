<?php

namespace App\Events;

use App\Models\Deposit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DepositApproved
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Deposit $deposit
    ) {}
}
