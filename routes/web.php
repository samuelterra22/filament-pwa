<?php

use Illuminate\Support\Facades\Route;
use SamuelTerra22\FilamentPwa\Http\Controllers\PwaController;

Route::middleware(config('filament-pwa.middlewares', []))
    ->group(function () {
        Route::get('/manifest.json', [PwaController::class, 'manifest'])->name('pwa.manifest');
        Route::get('/offline', [PwaController::class, 'offline'])->name('pwa.offline');
        Route::get('/serviceworker.js', [PwaController::class, 'serviceWorker'])->name('pwa.serviceworker');
    });
