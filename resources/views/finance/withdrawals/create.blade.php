@extends('layouts.app')
@section('title', 'New Withdrawal')
@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">New Withdrawal</h1>
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('withdrawals.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
                <input type="number" name="amount" step="0.01" min="10" max="{{ auth()->user()->balance }}" required class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary">
                <p class="text-sm text-gray-500 mt-1">Available balance: ${{ number_format(auth()->user()->balance, 2) }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Method</label>
                <select name="method" required class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary">
                    <option value="crypto">Cryptocurrency</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                <select name="currency" required class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary">
                    <option value="USDT">USDT</option>
                    <option value="BTC">BTC</option>
                    <option value="ETH">ETH</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Wallet Address</label>
                <input type="text" name="wallet_address" required class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Network</label>
                <select name="network" required class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary">
                    <option value="ERC20">ERC20</option>
                    <option value="TRC20">TRC20</option>
                    <option value="BEP20">BEP20</option>
                </select>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded p-3 mb-4">
                <p class="text-sm text-yellow-800">A 2% withdrawal fee will be applied.</p>
            </div>
            <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-blue-600">Submit Withdrawal</button>
        </form>
    </div>
</div>
@endsection
