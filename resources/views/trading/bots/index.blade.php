@extends('layouts.app')

@section('title', 'Trading Bots')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Trading Bots</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($bots as $bot)
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $bot->name }}</h3>
                <span class="px-2 py-1 text-xs rounded-full bg-{{ $bot->risk_level === 'low' ? 'green' : ($bot->risk_level === 'high' ? 'red' : 'yellow') }}-100 text-{{ $bot->risk_level === 'low' ? 'green' : ($bot->risk_level === 'high' ? 'red' : 'yellow') }}-800">
                    {{ ucfirst($bot->risk_level) }} Risk
                </span>
            </div>
            
            <p class="text-gray-600 text-sm mb-4">{{ $bot->description }}</p>
            
            <div class="space-y-2 mb-4 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Symbol:</span>
                    <span class="font-medium">{{ $bot->symbol }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Min Investment:</span>
                    <span class="font-medium">${{ number_format($bot->min_investment, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Max Investment:</span>
                    <span class="font-medium">${{ number_format($bot->max_investment, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Expected Return:</span>
                    <span class="font-medium text-tradingGreen">{{ $bot->expected_return_min }}% - {{ $bot->expected_return_max }}%</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Duration:</span>
                    <span class="font-medium">{{ $bot->duration_days }} days</span>
                </div>
            </div>
            
            <form method="POST" action="{{ route('trading.activate') }}">
                @csrf
                <input type="hidden" name="bot_id" value="{{ $bot->id }}">
                <input type="number" name="investment_amount" step="0.01" min="{{ $bot->min_investment }}" max="{{ $bot->max_investment }}" 
                    class="w-full border rounded px-3 py-2 mb-3 text-sm" placeholder="Amount to invest" required>
                <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded hover:bg-blue-700 font-medium">
                    Activate Bot
                </button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
