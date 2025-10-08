@extends('layouts.app')
@section('title', 'P2P Transfers')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">P2P Transfers</h1>
        <a href="{{ route('p2p.transfer') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-600">New Transfer</a>
    </div>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($transfers as $transfer)
                    <tr>
                        <td class="px-6 py-4 text-sm">{{ $transfer->sender_id === auth()->id() ? 'Sent' : 'Received' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $transfer->sender_id === auth()->id() ? $transfer->receiver->name : $transfer->sender->name }}</td>
                        <td class="px-6 py-4 text-sm font-semibold">${{ number_format($transfer->amount, 2) }}</td>
                        <td class="px-6 py-4"><span class="px-2 text-xs rounded-full bg-green-100 text-green-800">{{ ucfirst($transfer->status) }}</span></td>
                        <td class="px-6 py-4 text-sm">{{ $transfer->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No transfers yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $transfers->links() }}</div>
</div>
@endsection
