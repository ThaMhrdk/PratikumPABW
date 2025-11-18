<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;


Route::get('/', function () {
    return view('welcome');
});

// routes mengunakan controller yakni akses controller 'MahasiswaController'
Route::resource('mahasiswa', MahasiswaController::class)->except(['show']); // Route '/mahasiswa'
Route::get('/mahasiswa/get-data', [MahasiswaController::class, 'getData'])->name('mahasiswa.get-data'); // Route JSON '/mahasiswa/get-data'
