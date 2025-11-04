<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
});