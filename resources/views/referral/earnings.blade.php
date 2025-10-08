@extends('layouts.app')

@section('title', 'Referral Earnings')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Referral Earnings</h1>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-tradingGreen">${{ number_format($totalEarnings, 2) }}</h2>
        <p class="text-gray-600">Total Referral Earnings</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Earnings by Level</h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @foreach($earningsByLevel as $earning)
            <div class="text-center p-4 bg-gray-50 rounded">
                <p class="text-2xl font-bold text-primary">${{ number_format($earning->total, 2) }}</p>
                <p class="text-sm text-gray-600">Level {{ $earning->level }}</p>
                <p class="text-xs text-gray-500">{{ $earning->count }} earnings</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Recent Earnings</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">From</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commission</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentEarnings as $earning)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $earning->referredUser->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $earning->level }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-tradingGreen">${{ number_format($earning->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $earning->commission_rate }}%</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $earning->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
