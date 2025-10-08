<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWithdrawalRequest;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = auth()->user()->withdrawals()
            ->latest()
            ->paginate(15);

        return view('finance.withdrawals.index', compact('withdrawals'));
    }

    public function create()
    {
        return view('finance.withdrawals.create');
    }

    public function store(StoreWithdrawalRequest $request)
    {
        $user = auth()->user();
        $amount = $request->amount;
        $fee = $amount * 0.02; // 2% fee
        $netAmount = $amount - $fee;

        if ($user->balance < $amount) {
            return back()->with('error', 'Insufficient balance.');
        }

        DB::beginTransaction();
        try {
            $balanceBefore = $user->balance;
            $user->decrement('balance', $amount);
            $user->refresh();

            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'fee' => $fee,
                'net_amount' => $netAmount,
                'method' => $request->method,
                'currency' => $request->currency,
                'wallet_address' => $request->wallet_address,
                'network' => $request->network,
                'status' => Withdrawal::STATUS_PENDING,
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'type' => Transaction::TYPE_WITHDRAWAL,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->balance,
                'reference' => $withdrawal->id,
                'reference_type' => 'withdrawal',
                'description' => 'Withdrawal request',
            ]);

            DB::commit();

            return redirect()->route('withdrawals.index')
                ->with('success', 'Withdrawal request submitted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process withdrawal.');
        }
    }

    public function adminIndex()
    {
        $withdrawals = Withdrawal::with('user')
            ->latest()
            ->paginate(20);

        return view('finance.withdrawals.admin', compact('withdrawals'));
    }

    public function approve(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== Withdrawal::STATUS_PENDING) {
            return back()->with('error', 'This withdrawal cannot be approved.');
        }

        $withdrawal->update([
            'status' => Withdrawal::STATUS_COMPLETED,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'processed_at' => now(),
        ]);

        return back()->with('success', 'Withdrawal approved successfully!');
    }

    public function reject(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        if ($withdrawal->status !== Withdrawal::STATUS_PENDING) {
            return back()->with('error', 'This withdrawal cannot be rejected.');
        }

        DB::beginTransaction();
        try {
            $user = $withdrawal->user;
            $balanceBefore = $user->balance;
            
            $user->increment('balance', $withdrawal->amount);
            $user->refresh();

            $withdrawal->update([
                'status' => Withdrawal::STATUS_REJECTED,
                'rejected_at' => now(),
                'rejection_reason' => $request->rejection_reason,
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'type' => Transaction::TYPE_ADJUST,
                'amount' => $withdrawal->amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->balance,
                'reference' => $withdrawal->id,
                'reference_type' => 'withdrawal',
                'description' => 'Withdrawal refund (rejected)',
            ]);

            DB::commit();

            return back()->with('success', 'Withdrawal rejected and balance refunded.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to reject withdrawal.');
        }
    }
}
