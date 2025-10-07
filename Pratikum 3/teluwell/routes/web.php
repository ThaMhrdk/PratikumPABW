<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return redirect('/booking');
});

Route::get('/booking', [BookingController::class, 'index']);
Route::post('/booking/simpan', [BookingController::class, 'store']);
Route::get('/booking/reset', [BookingController::class, 'reset']);
