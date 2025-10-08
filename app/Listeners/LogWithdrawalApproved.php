<?php

namespace App\Listeners;

use App\Events\WithdrawalApproved;
use Illuminate\Support\Facades\Log;

class LogWithdrawalApproved
{
    public function handle(WithdrawalApproved $event): void
    {
        Log::info('Withdrawal approved', [
            'user_id' => $event->withdrawal->user_id,
            'withdrawal_id' => $event->withdrawal->id,
            'amount' => $event->withdrawal->amount,
            'approved_by' => $event->withdrawal->approved_by,
            'timestamp' => $event->timestamp,
        ]);
    }
}
