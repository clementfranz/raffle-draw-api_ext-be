<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PingController extends Controller
{
    /**
     * Handle ping request to check server status.
     */
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now(),
        ]);
    }
}
