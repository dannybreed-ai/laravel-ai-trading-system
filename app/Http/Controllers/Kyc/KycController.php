<?php

namespace App\Http\Controllers\Kyc;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKycRequest;
use App\Models\KycRecord;
use Illuminate\Http\Request;

class KycController extends Controller
{
    public function submit()
    {
        $existingKyc = auth()->user()->kycRecords()->latest()->first();

        return view('kyc.submit', compact('existingKyc'));
    }

    public function store(StoreKycRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status'] = KycRecord::STATUS_PENDING;

        if ($request->hasFile('front_image')) {
            $data['front_path'] = $request->file('front_image')->store('kyc', 'public');
        }

        if ($request->hasFile('back_image')) {
            $data['back_path'] = $request->file('back_image')->store('kyc', 'public');
        }

        if ($request->hasFile('selfie_image')) {
            $data['selfie_path'] = $request->file('selfie_image')->store('kyc', 'public');
        }

        KycRecord::create($data);

        return redirect()->route('user.dashboard')
            ->with('success', 'KYC documents submitted successfully! We will review them shortly.');
    }

    public function adminIndex()
    {
        $kycRecords = KycRecord::with('user')
            ->latest()
            ->paginate(20);

        return view('kyc.admin', compact('kycRecords'));
    }

    public function review(KycRecord $kycRecord)
    {
        return view('kyc.review', compact('kycRecord'));
    }

    public function approve(KycRecord $kycRecord)
    {
        if ($kycRecord->status !== KycRecord::STATUS_PENDING) {
            return back()->with('error', 'This KYC record cannot be approved.');
        }

        $kycRecord->update([
            'status' => KycRecord::STATUS_APPROVED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $kycRecord->user->update([
            'kyc_verified_at' => now(),
        ]);

        return back()->with('success', 'KYC approved successfully!');
    }

    public function reject(Request $request, KycRecord $kycRecord)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        if ($kycRecord->status !== KycRecord::STATUS_PENDING) {
            return back()->with('error', 'This KYC record cannot be rejected.');
        }

        $kycRecord->update([
            'status' => KycRecord::STATUS_REJECTED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'KYC rejected.');
    }
}
