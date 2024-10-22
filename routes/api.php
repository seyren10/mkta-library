<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemBomController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\WorkCenterController;
use App\Http\Controllers\ItemRoutingController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])
    ->prefix('v1')->group(function () {
        require __DIR__ . '/item.php';

        Route::apiResource('work-centers', WorkCenterController::class)->only(['index', 'show']);
        Route::apiResource('materials', MaterialController::class)->only(['index', 'show']);
        Route::apiResource('item-boms', ItemBomController::class)->only(['index', 'show']);

        Route::prefix('item-routings')->controller(ItemRoutingController::class)->group(function () {
            Route::get('', 'index');
            Route::prefix('{item_routing}')->group(function () {
                Route::get('', 'show');
                Route::post('notes', 'storeNote');
            });
            Route::prefix('notes')->group(function () {
                Route::put('{note}', 'updateNote');
                Route::delete('{note}', 'destroyNote');
            });
        });
    });
