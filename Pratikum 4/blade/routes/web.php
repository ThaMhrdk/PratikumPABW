<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\DashboardController;

Route::get('/TeluWell', [DashboardController::class, 'index'])->name('dashboard');
