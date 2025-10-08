@extends('layouts.app')

@section('title', 'KYC Verification')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">KYC Verification</h1>

    @if($kyc && $kyc->status === 'pending')
    <div class="bg-yellow-50 border border-yellow-400 p-4 rounded mb-6">
        <p class="text-yellow-700">Your KYC submission is pending review. Please wait for admin approval.</p>
    </div>
    @elseif($kyc && $kyc->status === 'approved')
    <div class="bg-green-50 border border-green-400 p-4 rounded mb-6">
        <p class="text-green-700">Your KYC has been approved!</p>
    </div>
    @else
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('kyc.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Document Type</label>
                <select name="document_type" class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('document_type') border-red-500 @enderror" required>
                    <option value="">Select Document Type</option>
                    <option value="passport">Passport</option>
                    <option value="id_card">ID Card</option>
                    <option value="drivers_license">Driver's License</option>
                </select>
                @error('document_type')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Document Number</label>
                <input type="text" name="document_number" class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('document_number') border-red-500 @enderror" required>
                @error('document_number')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Document Front</label>
                <input type="file" name="document_front" accept="image/*,application/pdf" class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('document_front') border-red-500 @enderror" required>
                <p class="text-gray-500 text-xs mt-1">JPG, JPEG, PNG, PDF (Max 4MB)</p>
                @error('document_front')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Document Back (Optional)</label>
                <input type="file" name="document_back" accept="image/*,application/pdf" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                <p class="text-gray-500 text-xs mt-1">JPG, JPEG, PNG, PDF (Max 4MB)</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Selfie with Document</label>
                <input type="file" name="selfie" accept="image/*" class="shadow border rounded w-full py-2 px-3 text-gray-700 @error('selfie') border-red-500 @enderror" required>
                <p class="text-gray-500 text-xs mt-1">JPG, JPEG, PNG (Max 4MB)</p>
                @error('selfie')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                Submit KYC
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
