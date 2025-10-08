@extends('layouts.app')
@section('title', 'Referral Earnings')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-8">Referral Earnings</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-600 mb-1">Total Earnings</p>
            <p class="text-2xl font-bold text-tradingGreen">${{ number_format($stats['total_earnings'], 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-600 mb-1">Total Referrals</p>
            <p class="text-2xl font-bold">{{ $stats['total_referrals'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-sm text-gray-600 mb-1">This Month</p>
            <p class="text-2xl font-bold text-tradingGreen">${{ number_format($stats['this_month_earnings'], 2) }}</p>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Earnings History</h2>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">From User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Level</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($earnings as $earning)
                    <tr>
                        <td class="px-6 py-4 text-sm">{{ $earning->fromUser->name }}</td>
                        <td class="px-6 py-4 text-sm">Level {{ $earning->level }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-tradingGreen">${{ number_format($earning->amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm">{{ $earning->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">No earnings yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $earnings->links() }}</div>
</div>
@endsection
