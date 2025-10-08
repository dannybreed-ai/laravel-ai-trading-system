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
        $kyc = auth()->user()->kycRecords()->latest()->first();
        return view('kyc.submit', compact('kyc'));
    }

    public function store(StoreKycRequest $request)
    {
        $user = auth()->user();

        // Check if user already has approved KYC
        if ($user->isKycVerified()) {
            return back()->with('error', 'Your KYC is already verified.');
        }

        // Store uploaded files
        $documentFrontPath = $request->file('document_front')->store('kyc/documents', 'public');
        $documentBackPath = $request->hasFile('document_back') 
            ? $request->file('document_back')->store('kyc/documents', 'public') 
            : null;
        $selfiePath = $request->file('selfie')->store('kyc/selfies', 'public');

        KycRecord::create([
            'user_id' => $user->id,
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'document_front_path' => $documentFrontPath,
            'document_back_path' => $documentBackPath,
            'selfie_path' => $selfiePath,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'KYC documents submitted successfully. Awaiting review.');
    }

    public function adminReview()
    {
        $pending = KycRecord::with('user')->pending()->latest()->paginate(20);
        return view('kyc.review', compact('pending'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'admin_note' => ['nullable', 'string', 'max:500'],
        ]);

        $kycRecord = KycRecord::findOrFail($id);

        $kycRecord->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        // Update user's KYC status if approved
        if ($request->status === 'approved') {
            $kycRecord->user->update([
                'kyc_verified_at' => now(),
            ]);
        }

        return back()->with('success', 'KYC status updated successfully.');
    }
}
