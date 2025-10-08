@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">💰</span>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Balance</dt>
                            <dd class="text-lg font-medium text-gray-900">${{ number_format($data['balance'], 2) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">🤖</span>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Active Bots</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $data['active_bots_count'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">📈</span>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Profit</dt>
                            <dd class="text-lg font-medium text-tradingGreen">${{ number_format($data['total_profit'], 2) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">👥</span>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Referral Earnings</dt>
                            <dd class="text-lg font-medium text-gray-900">${{ number_format($data['referral_earnings'], 2) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($data['kyc_status'] !== 'verified')
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    Your KYC is not verified yet. <a href="{{ route('kyc.submit') }}" class="font-medium underline text-yellow-700 hover:text-yellow-600">Complete KYC verification</a> to unlock all features.
                </p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Active Bots</h2>
            @if($data['active_bots']->isEmpty())
                <p class="text-gray-500 text-sm">No active bots. <a href="{{ route('trading.bots') }}" class="text-primary hover:underline">Activate a bot</a></p>
            @else
                <div class="space-y-4">
                    @foreach($data['active_bots'] as $activation)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-900">{{ $activation->bot->name }}</h3>
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div>
                                <span class="text-gray-500">Investment:</span>
                                <span class="text-gray-900 font-medium">${{ number_format($activation->investment_amount, 2) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Profit:</span>
                                <span class="text-tradingGreen font-medium">${{ number_format($activation->current_profit, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Transactions</h2>
            @if($data['recent_transactions']->isEmpty())
                <p class="text-gray-500 text-sm">No transactions yet.</p>
            @else
                <div class="space-y-3">
                    @foreach($data['recent_transactions'] as $transaction)
                    <div class="flex justify-between items-center text-sm border-b pb-2">
                        <div>
                            <p class="font-medium text-gray-900">{{ ucwords(str_replace('_', ' ', $transaction->type)) }}</p>
                            <p class="text-gray-500 text-xs">{{ $transaction->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <span class="font-medium {{ $transaction->amount >= 0 ? 'text-tradingGreen' : 'text-tradingRed' }}">
                            {{ $transaction->amount >= 0 ? '+' : '' }}${{ number_format($transaction->amount, 2) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
