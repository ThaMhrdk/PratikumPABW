<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LamaranController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes - Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('api.profile');

    // Lamaran CRUD - with api. prefix for names
    Route::get('/lowongan', [LamaranController::class, 'getLowongan'])->name('api.lowongan.index');
    Route::apiResource('lamaran', LamaranController::class)->names([
        'index' => 'api.lamaran.index',
        'store' => 'api.lamaran.store',
        'show' => 'api.lamaran.show',
        'update' => 'api.lamaran.update',
        'destroy' => 'api.lamaran.destroy',
    ]);
    Route::post('/lamaran/{lamaran}/upload-cv', [LamaranController::class, 'uploadCV'])->name('api.lamaran.upload-cv');
});

