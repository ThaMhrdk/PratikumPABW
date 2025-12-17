<?php

use Illuminate\Support\Facades\Route;
use Modules\JobFinder\App\Http\Controllers\Api\AuthApiController;
use Modules\JobFinder\App\Http\Controllers\Api\LamaranApiController;

/*
|--------------------------------------------------------------------------
| API Routes - JobFinder Module
|--------------------------------------------------------------------------
*/

// ============================================
// API Autentikasi
// ============================================
Route::prefix('v1/auth')->group(function () {
    Route::post('/register', [AuthApiController::class, 'register']);
    Route::post('/login', [AuthApiController::class, 'login']);

    // Route yang memerlukan autentikasi
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthApiController::class, 'logout']);
        Route::get('/profile', [AuthApiController::class, 'profile']);
    });
});

// ============================================
// API CRUD Lamaran
// ============================================
Route::prefix('v1/lamaran')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [LamaranApiController::class, 'index']);
    Route::post('/', [LamaranApiController::class, 'store']);
    Route::get('/{id}', [LamaranApiController::class, 'show']);
    Route::post('/{id}', [LamaranApiController::class, 'update']); // POST untuk form-data dengan file
    Route::delete('/{id}', [LamaranApiController::class, 'destroy']);
    Route::get('/{id}/download-cv', [LamaranApiController::class, 'downloadCV']);
});
