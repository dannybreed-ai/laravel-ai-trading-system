@extends('layouts.app')
@section('title', 'KYC Verification')
@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">KYC Verification</h1>
    
    @if($existingKyc && $existingKyc->status === 'pending')
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <p class="text-yellow-800">Your KYC submission is pending review.</p>
        </div>
    @elseif($existingKyc && $existingKyc->status === 'approved')
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <p class="text-green-800">Your KYC is verified!</p>
        </div>
    @else
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('kyc.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Document Type</label>
                    <select name="document_type" required class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary">
                        <option value="passport">Passport</option>
                        <option value="drivers_license">Driver's License</option>
                        <option value="national_id">National ID</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Document Number</label>
                    <input type="text" name="document_number" required class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Front Image</label>
                    <input type="file" name="front_image" accept=".jpg,.jpeg,.png,.pdf" required class="w-full">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Back Image (optional)</label>
                    <input type="file" name="back_image" accept=".jpg,.jpeg,.png,.pdf" class="w-full">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Selfie with Document</label>
                    <input type="file" name="selfie_image" accept=".jpg,.jpeg,.png" required class="w-full">
                </div>
                <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-blue-600">Submit KYC</button>
            </form>
        </div>
    @endif
</div>
@endsection
