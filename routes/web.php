<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransWebhookController;

// Import Controller Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;

/*
|--------------------------------------------------------------------------
| User / Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Checkout & Payment Gateway
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

// Webhook Midtrans
Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handle']);

/*
|--------------------------------------------------------------------------
| Admin Area Routes (Prefix: admin, Name: admin.*)
|--------------------------------------------------------------------------
*/
// Rute Login (Diletakkan di luar agar namanya tepat 'login' saat ditendang middleware auth)
Route::get('admin/login', [AuthController::class, 'showLogin'])->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Proses Autentikasi Admin
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Grup Rute Terproteksi (Wajib Login & Role Admin)
    Route::middleware(['auth', 'admin'])->group(function () {
        
        // Dashboard Utama Admin
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // CRUD Event
        Route::resource('events', EventAdminController::class);

        // Laporan Transaksi
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

        // CRUD Categories (Sesuai Tugas Modul 6)
        Route::resource('categories', CategoryController::class);
        Route::resource('partners', PartnerController::class);
    });
});