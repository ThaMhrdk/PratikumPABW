<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventaris\Http\Controllers\InventarisController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('inventaris', InventarisController::class)->names('inventaris');
});
