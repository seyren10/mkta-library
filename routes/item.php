<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LibraryFileController;
use App\Http\Controllers\RoutingController;

Route::prefix('items')
    ->group(function () {
        Route::controller(ItemController::class)
            ->group(function () {
                Route::get('', 'index');
                Route::get('{item}', 'show');
            });

        Route::prefix('{item}/routings')
            ->controller(RoutingController::class)
            ->group(function () {
                Route::get('', 'index');
                Route::get('{id}', 'show');
                Route::get('sequence/{sequence_index}/next', 'nextSequence');
                Route::get('sequence/{sequence_index}/prev', 'prevSequence');
            });

        Route::prefix('{item}/uploads')
            ->controller(LibraryFileController::class)
            ->group(function () {
                Route::post('documents', 'uploadDocuments');
                Route::post('images', 'uploadImages');
            });
    });
