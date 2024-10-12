<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemBomController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\WorkCenterController;
use App\Http\Controllers\ItemRoutingController;
use App\Http\Controllers\GenerateTokenController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])
    ->prefix('v1')->group(function () {
        require __DIR__ . '/item.php';

        Route::apiResource('work-centers', WorkCenterController::class)->only(['index', 'show']);
        Route::apiResource('materials', MaterialController::class)->only(['index', 'show']);
        Route::apiResource('item-routings', ItemRoutingController::class)->only(['index', 'show']);
        Route::apiResource('item-boms', ItemBomController::class)->only(['index', 'show']);
    });
