@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center py-20">
        <h1 class="text-5xl font-bold text-gray-900 mb-4">Laravel AI Trading System</h1>
        <p class="text-xl text-gray-600 mb-8">Automate your trading with AI-powered bots</p>
        <div class="space-x-4">
            @guest
                <a href="{{ route('register') }}" class="bg-primary text-white px-6 py-3 rounded-lg text-lg font-medium hover:bg-blue-700">Get Started</a>
                <a href="{{ route('login') }}" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg text-lg font-medium hover:bg-gray-300">Login</a>
            @else
                <a href="{{ route('dashboard') }}" class="bg-primary text-white px-6 py-3 rounded-lg text-lg font-medium hover:bg-blue-700">Go to Dashboard</a>
            @endguest
        </div>
    </div>
</div>
@endsection
