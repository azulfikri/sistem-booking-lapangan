<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminFieldController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminBookingController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// AUTH ROUTES
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});


Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

// Temporary route for testing - remove in production
Route::get('/logout-get', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login')->with('success', 'Berhasil logout!');
});

// ADMIN ROUTES (Protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Kelola Lapangan (Fields Management)
    Route::get('/lapangan', [AdminFieldController::class, 'index'])->name('lapangan');
    Route::get('/lapangan/create', [AdminFieldController::class, 'create'])->name('lapangan.create');
    Route::post('/lapangan', [AdminFieldController::class, 'store'])->name('lapangan.store');
    Route::get('/lapangan/{id}/edit', [AdminFieldController::class, 'edit'])->name('lapangan.edit');
    Route::put('/lapangan/{id}', [AdminFieldController::class, 'update'])->name('lapangan.update');
    Route::delete('/lapangan/{id}', [AdminFieldController::class, 'destroy'])->name('lapangan.destroy');

    // Manajemen Admin (User Management)
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Pesanan Masuk (Bookings)
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings');
    Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{id}/payment', [AdminBookingController::class, 'updatePaymentStatus'])->name('bookings.updatePayment');
    Route::patch('/bookings/{id}/status', [AdminBookingController::class, 'updateBookingStatus'])->name('bookings.updateStatus');
    Route::delete('/bookings/{id}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
});
