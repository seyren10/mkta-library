<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoutingController;



Route::prefix('items')->controller(ItemController::class)->group(function () {
    Route::get('', 'index');

    Route::prefix('{item}')->group(function () {
        Route::get('', 'show');

        Route::prefix('routings')->controller(RoutingController::class)->group(function () {
            Route::get('', 'index');
            Route::get('{id}', 'show');
        });
    });
});
