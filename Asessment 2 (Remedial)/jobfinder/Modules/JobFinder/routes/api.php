<?php

use Illuminate\Support\Facades\Route;
use Modules\JobFinder\Http\Controllers\Api\AuthController;
use Modules\JobFinder\Http\Controllers\Api\LamaranController;

/*
|--------------------------------------------------------------------------
| Module API Routes
|--------------------------------------------------------------------------
|
| RESTful API untuk Module JobFinder
| Prefix: /api/v1/module
|
*/

// Endpoint publik - Autentikasi
Route::prefix('v1/module')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('api.module.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.module.login');
});

// Endpoint terproteksi
Route::prefix('v1/module')->middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.module.logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('api.module.profile');

    // Daftar Lowongan
    Route::get('/lowongan', [LamaranController::class, 'getLowongan'])->name('api.module.lowongan.index');
    
    // CRUD Lamaran
    Route::get('/lamaran', [LamaranController::class, 'index'])->name('api.module.lamaran.index');
    Route::post('/lamaran', [LamaranController::class, 'store'])->name('api.module.lamaran.store');
    Route::get('/lamaran/{lamaran}', [LamaranController::class, 'show'])->name('api.module.lamaran.show');
    Route::put('/lamaran/{lamaran}', [LamaranController::class, 'update'])->name('api.module.lamaran.update');
    Route::delete('/lamaran/{lamaran}', [LamaranController::class, 'destroy'])->name('api.module.lamaran.destroy');
    Route::post('/lamaran/{lamaran}/upload-cv', [LamaranController::class, 'uploadCV'])->name('api.module.lamaran.upload-cv');
});
