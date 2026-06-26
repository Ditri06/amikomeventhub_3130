<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use  App\Http\Controllers\Admin\EventController  as  EventAdminController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\TransactionController;

// USER AREA
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/1', [EventController::class, 'show'])->name('events.show');
//Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])
    ->name('checkout.create');

Route::post('/checkout/{event}', [CheckoutController::class, 'store'])
    ->name('checkout.store');
Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
// ADMIN AREA
//Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
   // Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
   // Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
    // Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    //Route::get('/transaksi', [AdminEventController::class, 'transactions'])->name('transactions.index');
    // });

// Redirect login Laravel ke login admin
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// ADMIN AREA
Route::prefix('admin')->name('admin.')->group(function () {
     // LOGIN ADMIN
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

     // ROUTE YANG DILINDUNGI
    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('events', EventAdminController::class);

        Route::get('/categories', [CategoryController::class, 'index'])
            ->name('categories.index');

        //Route::get('/transaksi', [EventAdminController::class, 'transactions'])
            //->name('transactions.index');
        Route::get('/transactions', [TransactionController::class, 'index'])
            ->name('transactions.index');
    });
});

//Route::get('/', function () {
 //   return view('welcome');
//});
Route::get('/tentang', function () {
    return '<h1>Ini adalah Halaman Tentang Aplikasi Event Hub</h1>';
});

//Route::get('/', function () {
//    return view('home');
//});

Route::get('/kontak', function () {
 return view('contact');
});

Route::get('/profil', function () {
    return view('profil');
});

Route::get('/katalog', function () {
    return view('katalog');
});

Route::get('/bantuan', function () {
    return view('bantuan');
});
