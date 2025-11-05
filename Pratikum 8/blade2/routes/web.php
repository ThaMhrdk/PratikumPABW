<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontakController; // Pastikan ini di-import

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route ini akan mengalihkan halaman utama ke daftar kontak
Route::get('/', function () {
    return redirect()->route('kontaks.index');
});

// Route::resource akan otomatis membuat SEMUA route CRUD
// (index, create, store, show, edit, update, destroy)
Route::resource('kontaks', KontakController::class);