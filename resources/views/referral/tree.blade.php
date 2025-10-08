@extends('layouts.app')
@section('title', 'Referral Tree')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-8">Referral Tree</h1>
    
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="mb-4">
            <p class="text-sm text-gray-600 mb-2">Your Referral Code</p>
            <div class="flex items-center gap-2">
                <input type="text" value="{{ $user->referral_code }}" readonly class="px-4 py-2 border rounded-md font-mono text-lg">
                <button onclick="copyReferralCode()" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-600">Copy</button>
            </div>
        </div>
        <p class="text-sm text-gray-600">Share this code with friends to earn referral bonuses!</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Your Referrals ({{ $referrals->count() }})</h2>
        @forelse($referrals as $referral)
            <div class="border-b py-3 last:border-0">
                <p class="font-medium">{{ $referral->name }}</p>
                <p class="text-sm text-gray-500">Joined: {{ $referral->created_at->format('M d, Y') }}</p>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">No referrals yet</p>
        @endforelse
    </div>
</div>

<script>
function copyReferralCode() {
    const code = '{{ $user->referral_code }}';
    navigator.clipboard.writeText(code);
    alert('Referral code copied!');
}
</script>
@endsection
