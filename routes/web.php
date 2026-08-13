<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminFieldController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============================================================
// PUBLIC ROUTES
// ============================================================

// Homepage
Route::get('/', function () {
    $fields = \App\Models\Field::where('status', 'available')->latest()->take(4)->get();
    return view('welcome', compact('fields'));
})->name('home');

// Booking Routes (Public)
Route::prefix('booking')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/create/{fieldId}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/store', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.check-availability');
    Route::get('/{bookingCode}', [BookingController::class, 'show'])->name('booking.show');
});

// My Bookings (requires login)
Route::get('/my-bookings', [BookingController::class, 'myBookings'])->middleware('auth')->name('booking.my-bookings');

// ============================================================
// PAYMENT ROUTES
// ============================================================
Route::prefix('payment')->group(function () {
    Route::get('/process/{bookingCode}', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/callback', [PaymentController::class, 'callback'])->name('payment.callback');
});

// Midtrans Webhook (no CSRF)
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

// ============================================================
// AUTH ROUTES
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth')->name('logout');

// ============================================================
// ADMIN ROUTES (requires auth + admin middleware)
// ============================================================
Route::prefix('admin')->middleware('admin')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Lapangan Management
    Route::prefix('lapangan')->group(function () {
        Route::get('/', [AdminFieldController::class, 'index'])->name('admin.lapangan');
        Route::get('/create', [AdminFieldController::class, 'create'])->name('admin.lapangan.create');
        Route::post('/store', [AdminFieldController::class, 'store'])->name('admin.lapangan.store');
        Route::get('/{id}/edit', [AdminFieldController::class, 'edit'])->name('admin.lapangan.edit');
        Route::put('/{id}', [AdminFieldController::class, 'update'])->name('admin.lapangan.update');
        Route::delete('/{id}', [AdminFieldController::class, 'destroy'])->name('admin.lapangan.destroy');
    });

    // Booking Management
    Route::prefix('bookings')->group(function () {
        Route::get('/', [AdminBookingController::class, 'index'])->name('admin.bookings');
        Route::get('/{id}', [AdminBookingController::class, 'show'])->name('admin.bookings.show');
        Route::put('/{id}/payment-status', [AdminBookingController::class, 'updatePaymentStatus'])->name('admin.bookings.update-payment');
        Route::put('/{id}/booking-status', [AdminBookingController::class, 'updateBookingStatus'])->name('admin.bookings.update-status');
        Route::delete('/{id}', [AdminBookingController::class, 'destroy'])->name('admin.bookings.destroy');
    });

    // User Management
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.users');
        Route::get('/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/store', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    });
});
