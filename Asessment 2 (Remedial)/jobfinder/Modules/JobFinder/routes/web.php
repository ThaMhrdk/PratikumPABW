<?php

use Illuminate\Support\Facades\Route;
use Modules\JobFinder\Http\Controllers\DashboardController;
use Modules\JobFinder\Http\Controllers\LowonganController;
use Modules\JobFinder\Http\Controllers\LamaranController;

/*
|--------------------------------------------------------------------------
| Module Web Routes
|--------------------------------------------------------------------------
|
| Routes untuk Module JobFinder
| Semua route di sini memiliki prefix 'module' dan name 'jobfinder.'
|
*/

Route::prefix('module')->name('jobfinder.')->middleware(['web', 'auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ========================
    // LOWONGAN ROUTES
    // ========================
    
    // Lowongan - View untuk semua user
    Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
    Route::get('/lowongan/{lowongan}', [LowonganController::class, 'show'])->name('lowongan.show');
    
    // Lowongan - Admin only
    Route::middleware('role:admin')->group(function () {
        Route::get('/lowongan-create', [LowonganController::class, 'create'])->name('lowongan.create');
        Route::post('/lowongan', [LowonganController::class, 'store'])->name('lowongan.store');
        Route::get('/lowongan/{lowongan}/edit', [LowonganController::class, 'edit'])->name('lowongan.edit');
        Route::put('/lowongan/{lowongan}', [LowonganController::class, 'update'])->name('lowongan.update');
        Route::delete('/lowongan/{lowongan}', [LowonganController::class, 'destroy'])->name('lowongan.destroy');
    });

    // ========================
    // LAMARAN ROUTES
    // ========================
    
    // Lamaran - Semua user terautentikasi
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
