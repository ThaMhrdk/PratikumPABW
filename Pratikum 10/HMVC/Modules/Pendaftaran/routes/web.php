<?php

use Illuminate\Support\Facades\Route;
use Modules\Pendaftaran\Http\Controllers\PendaftaranController;

Route::group([], function () {
    Route::get('pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('pendaftaran/data', [PendaftaranController::class, 'getData'])->name('pendaftaran.data');
    Route::post('pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('pendaftaran/{id}/edit', [PendaftaranController::class, 'edit'])->name('pendaftaran.edit');
    Route::delete('pendaftaran/{id}', [PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');
});
