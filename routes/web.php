<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminFieldController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// AUTH ROUTES
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

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

    // Pesanan Masuk (Bookings)
    Route::get('/bookings', function () {
        return view('admin.bookings.index');
    })->name('bookings');
    
    Route::get('/bookings/{id}', function ($id) {
        return view('admin.bookings.show', compact('id'));
    })->name('bookings.show');
    
    Route::patch('/bookings/{id}/status', function ($id) {
        // Update booking status
    })->name('bookings.updateStatus');
});
