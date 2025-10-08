@extends('layouts.app')
@section('title', 'New Deposit')
@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">New Deposit</h1>
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('deposits.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
                <input type="number" name="amount" step="0.01" min="1" required class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary">
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Wallet Address (optional)</label>
                <input type="text" name="wallet_address" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Transaction Hash (optional)</label>
                <input type="text" name="tx_hash" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Proof</label>
                <input type="file" name="proof" accept=".jpg,.jpeg,.png,.pdf" class="w-full">
            </div>
            <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-blue-600">Submit Deposit</button>
        </form>
    </div>
</div>
@endsection
