<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\WhitelistedEmailController;
use App\Http\Controllers\Auth\EmailAuthController;




// Route::apiResource('participants', App\Http\Controllers\ParticipantController::class);
// Route::apiResource('winner-participants', App\Http\Controllers\WinnerParticipantController::class);
Route::apiResource('participant-batches', App\Http\Controllers\ParticipantBatchController::class);
Route::apiResource('cloud-syncs', App\Http\Controllers\CloudSyncController::class);
Route::get('ping', App\Http\Controllers\PingController::class);

require base_path('routes/api/participants.php');
require base_path('routes/api/winners.php');
require base_path('routes/api/raffles.php');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/google-login', [AuthController::class, 'googleLogin']);

// LOGINS
Route::post('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
Route::post('/auth/login', [EmailAuthController::class, 'login']);

// WHITELISTING OF EMAILS
Route::post('/whitelist-email', [WhitelistedEmailController::class, 'store']);
Route::delete('/whitelist-email/{id}', [WhitelistedEmailController::class, 'destroy']);


Route::middleware('api')->get('/test', function (Request $request) {
    return response()->json(['message' => 'API is working!']);
});
