<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Kelola Lapangan (Fields Management)
    Route::get('/lapangan', function () {
        return view('admin.lapangan.index');
    })->name('lapangan');
    
    Route::get('/lapangan/create', function () {
        return view('admin.lapangan.create');
    })->name('lapangan.create');
    
    Route::post('/lapangan', function () {
        // Store logic here
    })->name('lapangan.store');
    
    Route::get('/lapangan/{id}/edit', function ($id) {
        return view('admin.lapangan.edit', compact('id'));
    })->name('lapangan.edit');
    
    Route::put('/lapangan/{id}', function ($id) {
        // Update logic here
    })->name('lapangan.update');
    
    Route::delete('/lapangan/{id}', function ($id) {
        // Delete logic here
    })->name('lapangan.destroy');

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
