@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-600 mb-1">Balance</p>
            <p class="text-2xl font-bold text-tradingGreen">${{ number_format($stats['balance'], 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-600 mb-1">Total Profit</p>
            <p class="text-2xl font-bold text-tradingGreen">${{ number_format($stats['total_profit'], 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-600 mb-1">Active Bots</p>
            <p class="text-2xl font-bold text-primary">{{ $stats['active_bots'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-600 mb-1">Referral Earnings</p>
            <p class="text-2xl font-bold text-tradingGreen">${{ number_format($referralStats['total_earnings'], 2) }}</p>
        </div>
    </div>

    @if(!auth()->user()->isKycVerified())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    Your account is not KYC verified. <a href="{{ route('kyc.submit') }}" class="font-medium underline">Complete KYC</a> to activate trading bots.
                </p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Active Bots</h2>
            </div>
            <div class="p-6">
                @forelse($activeBots as $activation)
                    <div class="mb-4 pb-4 border-b border-gray-100 last:border-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold">{{ $activation->bot->name }}</h3>
                                <p class="text-sm text-gray-600">Investment: ${{ number_format($activation->investment_amount, 2) }}</p>
                                <p class="text-sm text-tradingGreen">Profit: ${{ number_format($activation->profit_earned, 2) }}</p>
                            </div>
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Active</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No active bots</p>
                @endforelse
                <a href="{{ route('trading.activations') }}" class="block text-center text-primary hover:underline mt-4">View All</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Recent Transactions</h2>
            </div>
            <div class="p-6">
                @forelse($recentTransactions as $transaction)
                    <div class="mb-3 pb-3 border-b border-gray-100 last:border-0 flex justify-between items-center">
                        <div>
                            <p class="font-medium text-sm">{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</p>
                            <p class="text-xs text-gray-500">{{ $transaction->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <p class="font-semibold {{ $transaction->isCredit() ? 'text-tradingGreen' : 'text-tradingRed' }}">
                            {{ $transaction->isCredit() ? '+' : '-' }}${{ number_format(abs($transaction->amount), 2) }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No transactions yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
