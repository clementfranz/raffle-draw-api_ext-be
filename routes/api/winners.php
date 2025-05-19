<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Participant\IndexController;
use App\Http\Controllers\WinnerParticipant\StoreController;
use App\Http\Controllers\WinnerParticipant\ShowController;
// use App\Http\Controllers\Participant\UpdateController;
use App\Http\Controllers\WinnerParticipant\DeleteController;

Route::prefix('winner-participants')->group(function () {
    Route::post('/', StoreController::class); // Create a new participant
    Route::get('all/raffle-codes', action: [ShowController::class, "getAllRaffleCodesOnly"]); // Show a specific participant
    Route::get('/raffle-code/{raffleCode}', [ShowController::class, "getSingleViaRaffleCode"]); // Get all participants
    // Route::put('{id}', UpdateController::class); // Update a participant
    Route::delete('{raffleCode}', DeleteController::class); // Delete a participant
});
