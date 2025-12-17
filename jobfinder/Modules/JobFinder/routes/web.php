<?php

use Illuminate\Support\Facades\Route;
use Modules\JobFinder\App\Http\Controllers\DashboardController;
use Modules\JobFinder\App\Http\Controllers\LowonganController;
use Modules\JobFinder\App\Http\Controllers\LamaranController;
use Modules\JobFinder\App\Http\Middleware\CekAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes - JobFinder Module
|--------------------------------------------------------------------------
*/

// Route publik untuk halaman utama
Route::get('/', function () {
    return view('jobfinder::welcome');
})->name('home');

// Route yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {

    // ============================================
    // CRUD Lowongan (Admin Only) - AJAX
    // ============================================
    Route::prefix('lowongan')->middleware([CekAdmin::class])->group(function () {
        Route::get('/', [LowonganController::class, 'index'])->name('lowongan.index');
        Route::get('/data', [LowonganController::class, 'getData'])->name('lowongan.data');
        Route::post('/store', [LowonganController::class, 'store'])->name('lowongan.store');
        Route::get('/edit/{id}', [LowonganController::class, 'edit'])->name('lowongan.edit');
        Route::delete('/delete/{id}', [LowonganController::class, 'destroy'])->name('lowongan.destroy');
    });

    // Daftar Lowongan untuk Pelamar
    Route::get('/daftar-lowongan', [LowonganController::class, 'daftarLowongan'])->name('lowongan.daftar');

    // ============================================
    // CRUD Lamaran (Admin & Pelamar) - AJAX
    // ============================================
    Route::prefix('lamaran')->group(function () {
        Route::get('/', [LamaranController::class, 'index'])->name('lamaran.index');
        Route::get('/data', [LamaranController::class, 'getData'])->name('lamaran.data');
        Route::post('/store', [LamaranController::class, 'store'])->name('lamaran.store');
        Route::get('/edit/{id}', [LamaranController::class, 'edit'])->name('lamaran.edit');
        Route::delete('/delete/{id}', [LamaranController::class, 'destroy'])->name('lamaran.destroy');
        Route::post('/status/{id}', [LamaranController::class, 'updateStatus'])
            ->middleware([CekAdmin::class])
            ->name('lamaran.status');
        Route::get('/download-cv/{id}', [LamaranController::class, 'downloadCV'])->name('lamaran.download');
    });
});
