@extends('layouts.app')
@section('title', 'Withdrawals')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">My Withdrawals</h1>
        <a href="{{ route('withdrawals.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-600">New Withdrawal</a>
    </div>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Net Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($withdrawals as $withdrawal)
                    <tr>
                        <td class="px-6 py-4 text-sm">${{ number_format($withdrawal->amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm">${{ number_format($withdrawal->fee, 2) }}</td>
                        <td class="px-6 py-4 text-sm font-semibold">${{ number_format($withdrawal->net_amount, 2) }}</td>
                        <td class="px-6 py-4"><span class="px-2 text-xs rounded-full {{ $withdrawal->status === 'completed' ? 'bg-green-100 text-green-800' : ($withdrawal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($withdrawal->status) }}</span></td>
                        <td class="px-6 py-4 text-sm">{{ $withdrawal->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No withdrawals yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $withdrawals->links() }}</div>
</div>
@endsection
