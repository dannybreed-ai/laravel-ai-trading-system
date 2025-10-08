@extends('layouts.app')

@section('title', 'Referral Tree')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-4">Referral Tree</h1>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <p class="text-gray-700 mb-2"><strong>Your Referral Code:</strong> <span class="text-primary font-mono text-lg">{{ $user->referral_code }}</span></p>
        <p class="text-sm text-gray-500">Share this code with others to earn referral commissions up to {{ config('referral.max_depth') }} levels deep!</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Your Referrals</h2>
        @if(empty($referrals))
            <p class="text-gray-500">You don't have any referrals yet.</p>
        @else
            @foreach($referrals as $referral)
                <div class="mb-4 pl-{{ ($referral['level'] - 1) * 4 }} border-l-2 border-gray-300">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div>
                            <p class="font-medium text-gray-900">{{ $referral['user']->name }}</p>
                            <p class="text-sm text-gray-500">Level {{ $referral['level'] }} • Joined {{ $referral['user']->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    @if(!empty($referral['children']))
                        @foreach($referral['children'] as $child)
                            @include('referral.partials.tree-node', ['referral' => $child])
                        @endforeach
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
