@extends('layouts.app')
@section('title', 'P2P Transfer')
@section('content')
<div class="max-w-2xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">P2P Transfer</h1>
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('p2p.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Receiver Username or Email</label>
                <input type="text" name="receiver_username" required class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
                <input type="number" name="amount" step="0.01" min="0.01" max="{{ auth()->user()->balance }}" required class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary">
                <p class="text-sm text-gray-500 mt-1">Available: ${{ number_format(auth()->user()->balance, 2) }}</p>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description (optional)</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-primary"></textarea>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded p-3 mb-4">
                <p class="text-sm text-blue-800">A 1% transfer fee will be applied.</p>
            </div>
            <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-blue-600">Send Transfer</button>
        </form>
    </div>
</div>
@endsection
