<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemRoutingController;
use App\Http\Controllers\ItemRoutingNoteController;
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
                Route::prefix('{id}')->group(function () {
                    Route::get('', 'show');
                    Route::post('files', [LibraryFileController::class, 'itemRoutingUploadFiles']);
                    Route::delete('files/{library_file}', [LibraryFileController::class, 'itemRoutingDestroyFile']);
                });
                Route::get('sequence/{sequence_index}/next', 'nextSequence');
                Route::get('sequence/{sequence_index}/prev', 'prevSequence');
            });

        Route::prefix('{item}/files')
            ->controller(LibraryFileController::class)
            ->group(function () {
                Route::prefix('documents')->group(function () {
                    Route::get('', 'getDocuments');
                    Route::post('', 'uploadDocuments');
                    Route::delete('{library_file}', 'destroyDocument');
                });
                Route::prefix('images')->group(function () {
                    Route::get('', 'getImages');
                    Route::post('', 'uploadImages');
                    Route::delete('{id}', 'destroyImage');
                });
            });
    });
