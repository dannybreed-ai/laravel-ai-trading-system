<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel AI Trading System') }} - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-inter">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-xl font-bold text-primary">AI Trading</h1>
                    </div>
                    @auth
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('user.dashboard') ? 'border-b-2 border-primary text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">Dashboard</a>
                            <a href="{{ route('trading.bots') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('trading.*') ? 'border-b-2 border-primary text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">Trading</a>
                            <a href="{{ route('deposits.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700">Finance</a>
                            <a href="{{ route('referral.tree') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700">Referral</a>
                        </div>
                    @endauth
                </div>
                <div class="flex items-center">
                    @auth
                        <span class="text-sm text-gray-700 mr-4">Balance: <strong class="text-tradingGreen">${{ number_format(auth()->user()->balance, 2) }}</strong></span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700 mr-4">Login</a>
                        <a href="{{ route('register') }}" class="text-sm bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-600">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">{{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ session('error') }}</div>
        </div>
    @endif

    <main class="py-6">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
