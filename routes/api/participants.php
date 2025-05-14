<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Participant\IndexController;
use App\Http\Controllers\Participant\StoreController;
use App\Http\Controllers\Participant\ShowController;
use App\Http\Controllers\Participant\UpdateController;
use App\Http\Controllers\Participant\DeleteController;

Route::prefix('participants')->group(function () {
    Route::get('/', IndexController::class); // Get all participants
    Route::post('/', StoreController::class); // Create a new participant
    Route::get('/count', [ShowController::class, "count"]); // Show a specific participant
    Route::get('/page/{page}/size/{size}', [ShowController::class, "paginate"]); // Show a specific participant
    Route::get('{id}', [ShowController::class, "show"]); // Show a specific participant
    Route::put('{id}', UpdateController::class); // Update a participant
    Route::delete('{id}', DeleteController::class); // Delete a participant
});
