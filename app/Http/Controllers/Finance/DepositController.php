<?php

namespace App\Http\Controllers\Finance;

use App\Events\DepositApproved;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepositRequest;
use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = auth()->user()
            ->deposits()
            ->latest()
            ->paginate(20);

        return view('finance.deposits.index', compact('deposits'));
    }

    public function create()
    {
        return view('finance.deposits.create');
    }

    public function store(StoreDepositRequest $request)
    {
        $deposit = Deposit::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'network' => $request->network,
            'transaction_hash' => $request->transaction_hash,
            'wallet_address' => $request->wallet_address,
            'status' => 'pending',
        ]);

        return redirect()->route('deposits.index')
            ->with('success', 'Deposit request submitted successfully. Awaiting admin approval.');
    }

    public function adminIndex()
    {
        $deposits = Deposit::with('user')
            ->latest()
            ->paginate(20);

        return view('finance.deposits.admin', compact('deposits'));
    }

    public function approve($id)
    {
        $deposit = Deposit::findOrFail($id);

        if ($deposit->status !== 'pending') {
            return back()->with('error', 'Deposit has already been processed.');
        }

        DB::transaction(function () use ($deposit) {
            // Update deposit status
            $deposit->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            // Credit user balance
            $deposit->user->increment('balance', $deposit->amount);

            // Record transaction
            Transaction::create([
                'user_id' => $deposit->user_id,
                'type' => 'deposit',
                'amount' => $deposit->amount,
                'balance_after' => $deposit->user->fresh()->balance,
                'reference' => 'DEP-' . strtoupper(Str::random(10)),
                'description' => 'Deposit approved',
                'status' => 'completed',
            ]);

            event(new DepositApproved($deposit));
        });

        return back()->with('success', 'Deposit approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $deposit = Deposit::findOrFail($id);

        if ($deposit->status !== 'pending') {
            return back()->with('error', 'Deposit has already been processed.');
        }

        $deposit->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note,
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Deposit rejected.');
    }
}
