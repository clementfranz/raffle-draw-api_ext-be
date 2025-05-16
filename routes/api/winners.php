<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Participant\IndexController;
use App\Http\Controllers\WinnerParticipant\StoreController;
// use App\Http\Controllers\Participant\ShowController;
// use App\Http\Controllers\Participant\UpdateController;
use App\Http\Controllers\WinnerParticipant\DeleteController;

Route::prefix('winner-participants')->group(function () {
    // Route::get('/', IndexController::class); // Get all participants
    Route::post('/', StoreController::class); // Create a new participant
    // Route::get('{id}', [ShowController::class, "show"]); // Show a specific participant
    // Route::put('{id}', UpdateController::class); // Update a participant
    Route::delete('{raffleCode}', DeleteController::class); // Delete a participant
});
