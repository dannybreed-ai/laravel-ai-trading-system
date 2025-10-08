@extends('layouts.app')
@section('title', 'Review KYC')
@section('content')
<div class="max-w-4xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">Review KYC Submission</h1>
    <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-sm text-gray-600">User</p>
                <p class="font-semibold">{{ $kycRecord->user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Document Type</p>
                <p class="font-semibold">{{ ucfirst(str_replace('_', ' ', $kycRecord->document_type)) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Document Number</p>
                <p class="font-semibold">{{ $kycRecord->document_number }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Submitted</p>
                <p class="font-semibold">{{ $kycRecord->created_at->format('M d, Y') }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-3 gap-4 mb-6">
            @if($kycRecord->front_path)
                <div>
                    <p class="text-sm text-gray-600 mb-2">Front</p>
                    <img src="{{ Storage::url($kycRecord->front_path) }}" alt="Front" class="w-full h-48 object-cover rounded">
                </div>
            @endif
            @if($kycRecord->back_path)
                <div>
                    <p class="text-sm text-gray-600 mb-2">Back</p>
                    <img src="{{ Storage::url($kycRecord->back_path) }}" alt="Back" class="w-full h-48 object-cover rounded">
                </div>
            @endif
            @if($kycRecord->selfie_path)
                <div>
                    <p class="text-sm text-gray-600 mb-2">Selfie</p>
                    <img src="{{ Storage::url($kycRecord->selfie_path) }}" alt="Selfie" class="w-full h-48 object-cover rounded">
                </div>
            @endif
        </div>

        @if($kycRecord->status === 'pending')
            <div class="flex gap-4">
                <form method="POST" action="{{ route('admin.kyc.approve', $kycRecord) }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.kyc.reject', $kycRecord) }}" class="flex-1">
                    @csrf
                    <input type="text" name="rejection_reason" placeholder="Rejection reason" required class="w-full px-3 py-2 border rounded-md mb-2">
                    <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700">Reject</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
