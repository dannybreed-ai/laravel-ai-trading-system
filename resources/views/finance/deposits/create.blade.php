@extends('layouts.app')

@section('title', 'New Deposit')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">New Deposit</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('deposits.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Amount</label>
                <input type="number" name="amount" step="0.01" min="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('amount') border-red-500 @enderror" required>
                @error('amount')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Network</label>
                <select name="network" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('network') border-red-500 @enderror" required>
                    <option value="">Select Network</option>
                    <option value="BTC">Bitcoin (BTC)</option>
                    <option value="ETH">Ethereum (ETH)</option>
                    <option value="USDT-TRC20">USDT (TRC20)</option>
                    <option value="USDT-ERC20">USDT (ERC20)</option>
                    <option value="BNB">Binance Coin (BNB)</option>
                </select>
                @error('network')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Transaction Hash (Optional)</label>
                <input type="text" name="transaction_hash" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Wallet Address (Optional)</label>
                <input type="text" name="wallet_address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Submit Deposit
                </button>
                <a href="{{ route('deposits.index') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
