<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\P2pTransferRequest;
use App\Models\P2pTransfer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class P2pTransferController extends Controller
{
    public function index()
    {
        $sent = auth()->user()
            ->sentTransfers()
            ->with('receiver')
            ->latest()
            ->paginate(10);

        $received = auth()->user()
            ->receivedTransfers()
            ->with('sender')
            ->latest()
            ->paginate(10);

        return view('finance.p2p.index', compact('sent', 'received'));
    }

    public function create()
    {
        return view('finance.p2p.create');
    }

    public function store(P2pTransferRequest $request)
    {
        $sender = auth()->user();
        $receiver = User::where('referral_code', $request->receiver_code)->firstOrFail();

        // Check if trying to send to self
        if ($sender->id === $receiver->id) {
            return back()->with('error', 'You cannot transfer to yourself.');
        }

        // Check balance
        if ($sender->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance.');
        }

        DB::transaction(function () use ($sender, $receiver, $request) {
            $reference = 'P2P-' . strtoupper(Str::random(10));

            // Deduct from sender
            $sender->decrement('balance', $request->amount);

            // Add to receiver
            $receiver->increment('balance', $request->amount);

            // Create transfer record
            P2pTransfer::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $request->amount,
                'reference' => $reference,
                'note' => $request->note,
                'status' => 'completed',
            ]);

            // Record transactions
            Transaction::create([
                'user_id' => $sender->id,
                'type' => 'p2p_sent',
                'amount' => -$request->amount,
                'balance_after' => $sender->fresh()->balance,
                'reference' => $reference,
                'description' => 'P2P transfer to ' . $receiver->name,
                'status' => 'completed',
            ]);

            Transaction::create([
                'user_id' => $receiver->id,
                'type' => 'p2p_received',
                'amount' => $request->amount,
                'balance_after' => $receiver->fresh()->balance,
                'reference' => $reference,
                'description' => 'P2P transfer from ' . $sender->name,
                'status' => 'completed',
            ]);
        });

        return redirect()->route('p2p.index')
            ->with('success', 'Transfer completed successfully!');
    }
}
