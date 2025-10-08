<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\UserDashboardController;
use App\Http\Controllers\Finance\DepositController;
use App\Http\Controllers\Finance\P2pTransferController;
use App\Http\Controllers\Finance\WithdrawalController;
use App\Http\Controllers\Kyc\KycController;
use App\Http\Controllers\Referral\ReferralController;
use App\Http\Controllers\Trading\TradingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// User Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Trading Routes
    Route::prefix('trading')->name('trading.')->group(function () {
        Route::get('/bots', [TradingController::class, 'index'])->name('bots');
        Route::post('/bots/activate', [TradingController::class, 'activate'])->name('activate');
        Route::get('/activations', [TradingController::class, 'activations'])->name('activations');
        Route::post('/activations/{id}/close', [TradingController::class, 'close'])->name('close');
        Route::get('/history', [TradingController::class, 'tradeHistory'])->name('history');
    });

    // Finance Routes - Deposits
    Route::prefix('deposits')->name('deposits.')->group(function () {
        Route::get('/', [DepositController::class, 'index'])->name('index');
        Route::get('/create', [DepositController::class, 'create'])->name('create');
        Route::post('/', [DepositController::class, 'store'])->name('store');
    });

    // Finance Routes - Withdrawals
    Route::prefix('withdrawals')->name('withdrawals.')->group(function () {
        Route::get('/', [WithdrawalController::class, 'index'])->name('index');
        Route::get('/create', [WithdrawalController::class, 'create'])->name('create');
        Route::post('/', [WithdrawalController::class, 'store'])->name('store');
    });

    // P2P Transfer Routes
    Route::prefix('p2p')->name('p2p.')->group(function () {
        Route::get('/', [P2pTransferController::class, 'index'])->name('index');
        Route::get('/create', [P2pTransferController::class, 'create'])->name('create');
        Route::post('/', [P2pTransferController::class, 'store'])->name('store');
    });

    // KYC Routes
    Route::prefix('kyc')->name('kyc.')->group(function () {
        Route::get('/submit', [KycController::class, 'submit'])->name('submit');
        Route::post('/submit', [KycController::class, 'store'])->name('store');
    });

    // Referral Routes
    Route::prefix('referral')->name('referral.')->group(function () {
        Route::get('/tree', [ReferralController::class, 'tree'])->name('tree');
        Route::get('/earnings', [ReferralController::class, 'earnings'])->name('earnings');
    });
});

// Admin Routes
Route::middleware(['auth', 'admin', 'throttle:60,1'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin Deposit Management
    Route::prefix('deposits')->name('deposits.')->group(function () {
        Route::get('/', [DepositController::class, 'adminIndex'])->name('index');
        Route::post('/{id}/approve', [DepositController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [DepositController::class, 'reject'])->name('reject');
    });

    // Admin Withdrawal Management
    Route::prefix('withdrawals')->name('withdrawals.')->group(function () {
        Route::get('/', [WithdrawalController::class, 'adminIndex'])->name('index');
        Route::post('/{id}/approve', [WithdrawalController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [WithdrawalController::class, 'reject'])->name('reject');
    });

    // Admin KYC Management
    Route::prefix('kyc')->name('kyc.')->group(function () {
        Route::get('/review', [KycController::class, 'adminReview'])->name('review');
        Route::post('/{id}/update', [KycController::class, 'updateStatus'])->name('update');
    });
});
