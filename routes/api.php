<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::apiResource('participants', App\Http\Controllers\ParticipantController::class);
Route::apiResource('winner-participants', App\Http\Controllers\WinnerParticipantController::class);
Route::apiResource('participant-batches', App\Http\Controllers\ParticipantBatchController::class);
Route::apiResource('cloud-syncs', App\Http\Controllers\CloudSyncController::class);
Route::get('ping', App\Http\Controllers\PingController::class);

require base_path('routes/api/participants.php');
require base_path('routes/api/winners.php');
require base_path('routes/api/raffles.php');

Route::middleware('api')->get('/test', function (Request $request) {
    return response()->json(['message' => 'API is working!']);
});
