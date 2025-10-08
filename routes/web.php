<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\UserDashboardController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Trading\TradingController;
use App\Http\Controllers\Finance\DepositController;
use App\Http\Controllers\Finance\WithdrawalController;
use App\Http\Controllers\Finance\P2pTransferController;
use App\Http\Controllers\Kyc\KycController;
use App\Http\Controllers\Referral\ReferralController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// User Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    
    // KYC Routes
    Route::get('/kyc/submit', [KycController::class, 'submit'])->name('kyc.submit');
    Route::post('/kyc/submit', [KycController::class, 'store'])->name('kyc.store');
    
    // Trading Routes
    Route::get('/trading/bots', [TradingController::class, 'bots'])->name('trading.bots');
    Route::get('/trading/activations', [TradingController::class, 'activations'])->name('trading.activations');
    Route::get('/trading/trades', [TradingController::class, 'trades'])->name('trading.trades');
    
    Route::middleware(['kyc.verified'])->group(function () {
        Route::post('/trading/bots/{bot}/activate', [TradingController::class, 'activateBot'])->name('trading.activate');
        Route::post('/trading/activations/{activation}/close', [TradingController::class, 'closeActivation'])->name('trading.close');
    });
    
    // Finance Routes
    Route::prefix('finance')->group(function () {
        Route::get('/deposits', [DepositController::class, 'index'])->name('deposits.index');
        Route::get('/deposits/create', [DepositController::class, 'create'])->name('deposits.create');
        Route::post('/deposits', [DepositController::class, 'store'])->name('deposits.store');
        
        Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::get('/withdrawals/create', [WithdrawalController::class, 'create'])->name('withdrawals.create');
        Route::post('/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');
    });
    
    // P2P Transfer Routes
    Route::get('/p2p', [P2pTransferController::class, 'index'])->name('p2p.index');
    Route::get('/p2p/transfer', [P2pTransferController::class, 'create'])->name('p2p.transfer');
    Route::post('/p2p/transfer', [P2pTransferController::class, 'store'])->name('p2p.store');
    
    // Referral Routes
    Route::get('/referral/tree', [ReferralController::class, 'tree'])->name('referral.tree');
    Route::get('/referral/earnings', [ReferralController::class, 'earnings'])->name('referral.earnings');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Deposit Management
    Route::get('/deposits', [DepositController::class, 'adminIndex'])->name('deposits.index');
    Route::post('/deposits/{deposit}/approve', [DepositController::class, 'approve'])->name('deposits.approve');
    Route::post('/deposits/{deposit}/reject', [DepositController::class, 'reject'])->name('deposits.reject');
    
    // Withdrawal Management
    Route::get('/withdrawals', [WithdrawalController::class, 'adminIndex'])->name('withdrawals.index');
    Route::post('/withdrawals/{withdrawal}/approve', [WithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('/withdrawals/{withdrawal}/reject', [WithdrawalController::class, 'reject'])->name('withdrawals.reject');
    
    // KYC Management
    Route::get('/kyc', [KycController::class, 'adminIndex'])->name('kyc.index');
    Route::get('/kyc/{kycRecord}/review', [KycController::class, 'review'])->name('kyc.review');
    Route::post('/kyc/{kycRecord}/approve', [KycController::class, 'approve'])->name('kyc.approve');
    Route::post('/kyc/{kycRecord}/reject', [KycController::class, 'reject'])->name('kyc.reject');
});
