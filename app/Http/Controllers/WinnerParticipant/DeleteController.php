<?php

namespace App\Http\Controllers\WinnerParticipant;

use App\Models\WinnerParticipant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log; // 👈 Add this line

class DeleteController extends Controller
{
    /**
     * Remove the specified participant by raffleCode.
     *
     * @param string $raffleCode
     * @return \Illuminate\Http\Response
     */
    public function __invoke($raffleCode)
    {

        $participant = WinnerParticipant::where('raffle_code', $raffleCode)->first();

        if (!$participant) {
            return response()->json(['message' => 'Participant not found'], 404);
        }

        $participant->delete();

        return response()->json(['message' => 'Participant deleted successfully']);
    }
}
