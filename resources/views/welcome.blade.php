@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center py-16">
        <h1 class="text-5xl font-bold text-gray-900 mb-4">Laravel AI Trading System</h1>
        <p class="text-xl text-gray-600 mb-8">Automated trading powered by artificial intelligence</p>
        <div class="space-x-4">
            <a href="{{ route('register') }}" class="bg-primary text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-600 inline-block">Get Started</a>
            <a href="{{ route('login') }}" class="bg-gray-200 text-gray-800 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-300 inline-block">Login</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-bold mb-2">AI-Powered Bots</h3>
            <p class="text-gray-600">Advanced trading algorithms that work 24/7</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-bold mb-2">Secure Platform</h3>
            <p class="text-gray-600">Bank-level security for your funds</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-bold mb-2">Referral Program</h3>
            <p class="text-gray-600">Earn up to 10 levels of referral commissions</p>
        </div>
    </div>
</div>
@endsection
