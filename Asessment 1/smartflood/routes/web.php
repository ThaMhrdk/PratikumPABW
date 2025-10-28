<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/tentang', function () {
    return view('tentang');
});

Route::get('/sensor', function () {
    return view('sensor');
});

Route::get('/laporan', function () {
    return view('laporan');
});