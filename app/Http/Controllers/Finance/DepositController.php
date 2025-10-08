<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepositRequest;
use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = auth()->user()->deposits()
            ->latest()
            ->paginate(15);

        return view('finance.deposits.index', compact('deposits'));
    }

    public function create()
    {
        return view('finance.deposits.create');
    }

    public function store(StoreDepositRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status'] = Deposit::STATUS_PENDING;

        if ($request->hasFile('proof')) {
            $data['proof_path'] = $request->file('proof')->store('deposits', 'public');
        }

        Deposit::create($data);

        return redirect()->route('deposits.index')
            ->with('success', 'Deposit request submitted successfully!');
    }

    public function adminIndex()
    {
        $deposits = Deposit::with('user')
            ->latest()
            ->paginate(20);

        return view('finance.deposits.admin', compact('deposits'));
    }

    public function approve(Deposit $deposit)
    {
        if ($deposit->status !== Deposit::STATUS_PENDING) {
            return back()->with('error', 'This deposit cannot be approved.');
        }

        DB::beginTransaction();
        try {
            $user = $deposit->user;
            $balanceBefore = $user->balance;
            
            $user->increment('balance', $deposit->amount);
            $user->refresh();

            $deposit->update([
                'status' => Deposit::STATUS_APPROVED,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            Transaction::create([
                'user_id' => $user->id,
                'type' => Transaction::TYPE_DEPOSIT,
                'amount' => $deposit->amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $user->balance,
                'reference' => $deposit->id,
                'reference_type' => 'deposit',
                'description' => 'Deposit approved',
            ]);

            DB::commit();

            return back()->with('success', 'Deposit approved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve deposit.');
        }
    }

    public function reject(Request $request, Deposit $deposit)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        if ($deposit->status !== Deposit::STATUS_PENDING) {
            return back()->with('error', 'This deposit cannot be rejected.');
        }

        $deposit->update([
            'status' => Deposit::STATUS_REJECTED,
            'rejected_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Deposit rejected.');
    }
}
