<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\P2pTransferRequest;
use App\Models\P2pTransfer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class P2pTransferController extends Controller
{
    public function index()
    {
        $transfers = P2pTransfer::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->with(['sender', 'receiver'])
            ->latest()
            ->paginate(15);

        return view('p2p.index', compact('transfers'));
    }

    public function create()
    {
        return view('p2p.transfer');
    }

    public function store(P2pTransferRequest $request)
    {
        $sender = auth()->user();
        $receiver = User::where('username', $request->receiver_username)
            ->orWhere('email', $request->receiver_username)
            ->first();

        if (!$receiver) {
            return back()->with('error', 'Receiver not found.');
        }

        if ($receiver->id === $sender->id) {
            return back()->with('error', 'Cannot transfer to yourself.');
        }

        $amount = $request->amount;
        $fee = $amount * 0.01; // 1% fee
        $netAmount = $amount - $fee;

        if ($sender->balance < $amount) {
            return back()->with('error', 'Insufficient balance.');
        }

        DB::beginTransaction();
        try {
            $senderBalanceBefore = $sender->balance;
            $sender->decrement('balance', $amount);
            $sender->refresh();

            $receiverBalanceBefore = $receiver->balance;
            $receiver->increment('balance', $netAmount);
            $receiver->refresh();

            $transfer = P2pTransfer::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $amount,
                'fee' => $fee,
                'net_amount' => $netAmount,
                'status' => P2pTransfer::STATUS_COMPLETED,
                'processed_at' => now(),
                'reference' => strtoupper(substr(md5(uniqid()), 0, 10)),
                'description' => $request->description,
            ]);

            Transaction::create([
                'user_id' => $sender->id,
                'type' => Transaction::TYPE_P2P_TRANSFER_OUT,
                'amount' => $amount,
                'balance_before' => $senderBalanceBefore,
                'balance_after' => $sender->balance,
                'reference' => $transfer->id,
                'reference_type' => 'p2p_transfer',
                'description' => "P2P transfer to {$receiver->username}",
            ]);

            Transaction::create([
                'user_id' => $receiver->id,
                'type' => Transaction::TYPE_P2P_TRANSFER_IN,
                'amount' => $netAmount,
                'balance_before' => $receiverBalanceBefore,
                'balance_after' => $receiver->balance,
                'reference' => $transfer->id,
                'reference_type' => 'p2p_transfer',
                'description' => "P2P transfer from {$sender->username}",
            ]);

            DB::commit();

            return redirect()->route('p2p.index')
                ->with('success', 'Transfer completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process transfer.');
        }
    }
}
