<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventaris\Http\Controllers\InventarisAjaxController;

Route::middleware(['auth'])->group(function () {

    // Route Bagian Inventaris Ajax (Asynchronous)
    Route::prefix('jobfinder')->group(function () {
        // Halaman Utama View
        Route::get('/', [InventarisAjaxController::class, 'index'])->name('ajax.index');

        // Route Khusus Data JSON (Dipanggil oleh Javascript)
        Route::get('/data', [InventarisAjaxController::class, 'getData'])->name('ajax.data');
        Route::post('/store', [InventarisAjaxController::class, 'store'])->name('ajax.store');
        Route::get('/edit/{id}', [InventarisAjaxController::class, 'edit'])->name('ajax.edit');
        Route::delete('/delete/{id}', [InventarisAjaxController::class, 'destroy'])->name('ajax.destroy');
    });
});
