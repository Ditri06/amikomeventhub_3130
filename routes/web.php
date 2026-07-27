<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\PartnerDashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\TicketTierController;
// ======================================================
// RUTE USER AREA
// ======================================================

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/event/{id}', [EventController::class, 'show'])
    ->name('events.show');

Route::post('/event/{event}/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store')
    ->middleware('auth');

Route::get('/my-ticket', [EventController::class, 'ticket'])
    ->name('ticket');

// ======================================================
// RUTE CHECKOUT
// ======================================================

Route::get('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'create'])
    ->name('checkout.create');

Route::post('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'store'])
    ->name('checkout.store');

Route::get('/payment/{order_id}', [App\Http\Controllers\CheckoutController::class, 'payment'])
    ->name('checkout.payment');

Route::get('/success/{order_id}', [App\Http\Controllers\CheckoutController::class, 'success'])
    ->name('checkout.success');

Route::post('/midtrans/callback', [App\Http\Controllers\MidtransWebhookController::class, 'handle']);


// ======================================================
// LOGIN
// ======================================================

// Jika user mengakses /login,
// diarahkan ke halaman login admin
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


// ======================================================
// GOOGLE LOGIN
// ======================================================

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])
    ->name('google.login');

Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->name('google.callback');


// ======================================================
// RUTE ADMIN
// ======================================================

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {

    // --------------------------------------------------
    // LOGIN & LOGOUT ADMIN
    // --------------------------------------------------

    Route::get('login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('login', [AuthController::class, 'login'])
        ->name('login.post');

    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');


    // --------------------------------------------------
    // AREA ADMIN
    // Wajib login + role admin
    // --------------------------------------------------

    Route::middleware(['auth', 'admin'])->group(function () {

        // Dashboard Admin
        // URL: /admin/dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');


        // Kelola Event
        // URL: /admin/events
        Route::resource('events', AdminEventController::class);


        // Kelola Kategori
        // URL: /admin/categories
        Route::resource('categories', CategoryController::class);


        // Kelola Partner
        // URL: /admin/partners
        Route::post('partners/{id}/approve', [PartnerController::class, 'approve'])
            ->name('partners.approve');

        Route::post('partners/{id}/reject', [PartnerController::class, 'reject'])
            ->name('partners.reject');

        Route::resource('partners', PartnerController::class);


        // Kelola Transaksi
        // URL: /admin/transactions
        Route::get(
            'transactions',
            [TransactionController::class, 'index']
        )->name('transactions.index');

        // Kelola Kupon
        // URL: /admin/coupons
        Route::resource('coupons', CouponController::class);

        // Kelola Ticket Tier
        // URL: /admin/ticket-tiers
        Route::resource('ticket-tiers', TicketTierController::class);


    });

});


// ======================================================
// RUTE KHUSUS PARTNER
// ======================================================

// Dashboard Partner
Route::middleware(['auth', 'partner'])->group(function () {

    // Dashboard Partner
    Route::get('/partner/dashboard', [PartnerDashboardController::class, 'index'])
        ->name('partner.dashboard');

    // CRUD Event Partner
    Route::resource('/partner/events', \App\Http\Controllers\PartnerEventController::class)
        ->names('partner.events');

     // Laporan Transaksi Partner
    Route::get('/partner/transactions', [\App\Http\Controllers\PartnerTransactionController::class, 'index'])
        ->name('partner.transactions.index');
});


// Detail Partner
Route::get('/partner/{id}', [App\Http\Controllers\PartnerController::class, 'show'])
    ->name('partner.show');

// ======================================================
// REGISTRASI PARTNER
// ======================================================

Route::get('/register', [RegisterController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');

// ======================================================
// ROUTE TEST
// ======================================================

Route::get('/test', function () {
    return 'Laravel Berhasil';
});
