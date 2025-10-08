@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-xs text-gray-600 mb-1">Total Users</p>
            <p class="text-xl font-bold">{{ $stats['total_users'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-xs text-gray-600 mb-1">Active Bots</p>
            <p class="text-xl font-bold text-tradingGreen">{{ $stats['active_bot_activations'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-xs text-gray-600 mb-1">Total Volume</p>
            <p class="text-xl font-bold">${{ number_format($stats['total_volume'], 0) }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-xs text-gray-600 mb-1">Pending Deposits</p>
            <p class="text-xl font-bold text-yellow-600">{{ $stats['pending_deposits'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-xs text-gray-600 mb-1">Pending KYC</p>
            <p class="text-xl font-bold text-yellow-600">{{ $stats['pending_kyc'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Recent Deposits</h2>
            </div>
            <div class="p-6">
                @forelse($recentDeposits as $deposit)
                    <div class="mb-3 pb-3 border-b last:border-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-sm">{{ $deposit->user->name }}</p>
                                <p class="text-xs text-gray-500">${{ number_format($deposit->amount, 2) }} - {{ $deposit->method }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded {{ $deposit->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($deposit->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No deposits</p>
                @endforelse
                <a href="{{ route('admin.deposits.index') }}" class="block text-center text-primary hover:underline mt-4">Manage Deposits</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Pending KYC</h2>
            </div>
            <div class="p-6">
                @forelse($pendingKyc as $kyc)
                    <div class="mb-3 pb-3 border-b last:border-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-sm">{{ $kyc->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $kyc->document_type)) }}</p>
                            </div>
                            <a href="{{ route('admin.kyc.review', $kyc) }}" class="text-xs text-primary hover:underline">Review</a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No pending KYC</p>
                @endforelse
                <a href="{{ route('admin.kyc.index') }}" class="block text-center text-primary hover:underline mt-4">View All</a>
            </div>
        </div>
    </div>
</div>
@endsection
