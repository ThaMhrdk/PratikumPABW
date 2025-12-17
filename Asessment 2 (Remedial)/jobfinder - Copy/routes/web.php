<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Lowongan - View for all, CRUD for admin only
    Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
    Route::get('/lowongan/{lowongan}', [LowonganController::class, 'show'])->name('lowongan.show');
    
    // Lowongan - Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/lowongan-create', [LowonganController::class, 'create'])->name('lowongan.create');
        Route::post('/lowongan', [LowonganController::class, 'store'])->name('lowongan.store');
        Route::get('/lowongan/{lowongan}/edit', [LowonganController::class, 'edit'])->name('lowongan.edit');
        Route::put('/lowongan/{lowongan}', [LowonganController::class, 'update'])->name('lowongan.update');
        Route::delete('/lowongan/{lowongan}', [LowonganController::class, 'destroy'])->name('lowongan.destroy');
    });

    // Lamaran - All authenticated users
    Route::get('/lamaran', [LamaranController::class, 'index'])->name('lamaran.index');
    Route::get('/lamaran/create', [LamaranController::class, 'create'])->name('lamaran.create');
    Route::post('/lamaran', [LamaranController::class, 'store'])->name('lamaran.store');
    Route::get('/lamaran/{lamaran}', [LamaranController::class, 'show'])->name('lamaran.show');
    Route::get('/lamaran/{lamaran}/edit', [LamaranController::class, 'edit'])->name('lamaran.edit');
    Route::put('/lamaran/{lamaran}', [LamaranController::class, 'update'])->name('lamaran.update');
    Route::get('/lamaran/{lamaran}/download-cv', [LamaranController::class, 'downloadCV'])->name('lamaran.download-cv');
    
    // Lamaran delete - Admin only
    Route::delete('/lamaran/{lamaran}', [LamaranController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('lamaran.destroy');
});

require __DIR__.'/auth.php';
