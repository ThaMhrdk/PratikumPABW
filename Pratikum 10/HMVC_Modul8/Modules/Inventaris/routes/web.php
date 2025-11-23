<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventaris\Http\Controllers\InventarisSyncController;
use Modules\Inventaris\Http\Controllers\InventarisAjaxController;

Route::middleware(['auth'])->group(function() {

    // Route Bagian Inventaris Sync (Synchronous)
    Route::prefix('inventaris-sync')->group(function() {
        Route::get('/', [InventarisSyncController::class, 'index'])->name('sync.index');
        Route::get('/create', [InventarisSyncController::class, 'create'])->name('sync.create');
        Route::post('/store', [InventarisSyncController::class, 'store'])->name('sync.store');
        Route::get('/edit/{id}', [InventarisSyncController::class, 'edit'])->name('sync.edit');
        Route::put('/update/{id}', [InventarisSyncController::class, 'update'])->name('sync.update');
        Route::delete('/delete/{id}', [InventarisSyncController::class, 'destroy'])->name('sync.destroy');
    });

    // Route Bagian Inventaris Ajax (Asynchronous)
    Route::prefix('inventaris-ajax')->group(function() {
        // Halaman Utama View
        Route::get('/', [InventarisAjaxController::class, 'index'])->name('ajax.index');

        // Route Khusus Data JSON (Dipanggil oleh Javascript)
        Route::get('/data', [InventarisAjaxController::class, 'getData'])->name('ajax.data');
        Route::post('/store', [InventarisAjaxController::class, 'store'])->name('ajax.store');
        Route::get('/edit/{id}', [InventarisAjaxController::class, 'edit'])->name('ajax.edit');
        Route::delete('/delete/{id}', [InventarisAjaxController::class, 'destroy'])->name('ajax.destroy');
    });

});
