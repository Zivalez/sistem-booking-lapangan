<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LapanganController;
use App\Http\Controllers\Backend\BookingController;
use App\Http\Controllers\Backend\LaporanController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/booking', [HomeController::class, 'store'])->name('booking.store');

// Backend Routes (Protected by Auth)
Route::middleware(['auth', 'verified'])->prefix('backend')->name('backend.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('lapangan', LapanganController::class);
    Route::resource('booking', BookingController::class);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::patch('/booking/{booking}/status', [BookingController::class, 'updateStatus'])->name('booking.update-status');
});

// Default Auth Routes
require __DIR__.'/auth.php';