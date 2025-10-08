@extends('layouts.app')

@section('title', 'Trading Bots')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Trading Bots</h1>
        <p class="text-gray-600 mt-2">Choose a bot to activate and start automated trading</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($bots as $bot)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                <div class="bg-gradient-trading p-6">
                    <h3 class="text-xl font-bold text-white">{{ $bot->name }}</h3>
                    <p class="text-white text-sm mt-1">{{ $bot->strategy_type }}</p>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 text-sm mb-4">{{ $bot->description }}</p>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Daily Profit:</span>
                            <span class="font-semibold text-tradingGreen">{{ $bot->daily_profit_range_min }}% - {{ $bot->daily_profit_range_max }}%</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Duration:</span>
                            <span class="font-semibold">{{ $bot->duration_days }} days</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Min Investment:</span>
                            <span class="font-semibold">${{ number_format($bot->min_investment, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Max Investment:</span>
                            <span class="font-semibold">${{ number_format($bot->max_investment, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Risk Level:</span>
                            <span class="font-semibold {{ $bot->risk_level === 'low' ? 'text-green-600' : ($bot->risk_level === 'medium' ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ ucfirst($bot->risk_level) }}
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('trading.activate', $bot) }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="number" name="investment_amount" step="0.01" min="{{ $bot->min_investment }}" max="{{ $bot->max_investment }}" 
                            placeholder="Investment amount" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                        <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-blue-600 font-semibold">
                            Activate Bot
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
