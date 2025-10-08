<?php

namespace App\Http\Controllers\Finance;

use App\Events\WithdrawalApproved;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWithdrawalRequest;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = auth()->user()
            ->withdrawals()
            ->latest()
            ->paginate(20);

        return view('finance.withdrawals.index', compact('withdrawals'));
    }

    public function create()
    {
        return view('finance.withdrawals.create');
    }

    public function store(StoreWithdrawalRequest $request)
    {
        $user = auth()->user();

        // Check if user has sufficient balance
        if ($user->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance.');
        }

        DB::transaction(function () use ($user, $request, &$withdrawal) {
            // Deduct balance
            $user->decrement('balance', $request->amount);

            // Create withdrawal request
            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'network' => $request->network,
                'wallet_address' => $request->wallet_address,
                'status' => 'pending',
            ]);

            // Record transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => -$request->amount,
                'balance_after' => $user->fresh()->balance,
                'reference' => 'WDR-' . strtoupper(Str::random(10)),
                'description' => 'Withdrawal request',
                'status' => 'pending',
            ]);
        });

        return redirect()->route('withdrawals.index')
            ->with('success', 'Withdrawal request submitted successfully. Awaiting admin approval.');
    }

    public function adminIndex()
    {
        $withdrawals = Withdrawal::with('user')
            ->latest()
            ->paginate(20);

        return view('finance.withdrawals.admin', compact('withdrawals'));
    }

    public function approve(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Withdrawal has already been processed.');
        }

        $withdrawal->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'transaction_hash' => $request->transaction_hash,
        ]);

        event(new WithdrawalApproved($withdrawal));

        return back()->with('success', 'Withdrawal approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Withdrawal has already been processed.');
        }

        DB::transaction(function () use ($withdrawal, $request) {
            // Return balance to user
            $withdrawal->user->increment('balance', $withdrawal->amount);

            // Update withdrawal status
            $withdrawal->update([
                'status' => 'rejected',
                'admin_note' => $request->admin_note,
                'approved_by' => auth()->id(),
            ]);

            // Update transaction status
            Transaction::where('user_id', $withdrawal->user_id)
                ->where('type', 'withdrawal')
                ->where('amount', -$withdrawal->amount)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);
        });

        return back()->with('success', 'Withdrawal rejected and balance returned.');
    }
}
