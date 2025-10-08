<?php

namespace App\Listeners;

use App\Events\DepositApproved;
use Illuminate\Support\Facades\Log;

class LogDepositApproved
{
    public function handle(DepositApproved $event): void
    {
        Log::info('Deposit approved', [
            'user_id' => $event->deposit->user_id,
            'deposit_id' => $event->deposit->id,
            'amount' => $event->deposit->amount,
            'approved_by' => $event->deposit->approved_by,
            'timestamp' => $event->timestamp,
        ]);
    }
}
