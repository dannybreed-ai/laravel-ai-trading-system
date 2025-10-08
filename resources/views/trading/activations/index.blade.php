@extends('layouts.app')

@section('title', 'My Bot Activations')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Bot Activations</h1>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bot</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Investment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Profit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Activated</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($activations as $activation)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $activation->bot->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($activation->investment_amount, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-tradingGreen">${{ number_format($activation->current_profit, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full bg-{{ $activation->status === 'active' ? 'green' : 'gray' }}-100 text-{{ $activation->status === 'active' ? 'green' : 'gray' }}-800">
                            {{ ucfirst($activation->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activation->activated_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($activation->status === 'active')
                        <form method="POST" action="{{ route('trading.close', $activation->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="text-primary hover:underline" onclick="return confirm('Are you sure you want to close this bot?')">Close</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $activations->links() }}
    </div>
</div>
@endsection
