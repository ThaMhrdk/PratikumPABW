<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('hello', function () {
    return 'Hello, Anantha';
});

Route::get('/user/{Anantha}', function ($Anantha) {
    return "Nama Saya $Anantha";
});

route::get("/greet/{Anantha?}", function ($Anantha = 'Guest') {
    return "Halo, $Anantha";
});

route::get('/profile', function () {
    return view('profile');
});

route::get('/about', function () {
    return view('about', ['name' => 'Anantha']);
});

Route::get('/home', function () {
    return 'Halo, Ini adalah halaman Home';
})->name('home.page');

Route::get('/form', [DataController::class, 'form']);
Route::post('/proses', [DataController::class, 'proses']);