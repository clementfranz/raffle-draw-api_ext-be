<?php

namespace App\Http\Controllers\Participant;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'full_name_raw' => 'required|string|max:255',
            'full_name_cleaned' => 'required|string|max:255',
            'id_entry' => 'required|integer',
            'raffle_code' => 'required|string|unique:participants,raffle_code|max:10',
            'regional_location' => 'required|string',
            'registered_at' => 'required|date',
            'uploaded_at' => 'required|date',
            'is_drawn' => 'required|boolean',
            'participant_batch_id' => 'required|exists:participant_batches,id',
        ]);

        // Create the participant
        $participant = Participant::create($validated);

        return response()->json($participant, 201);
    }
}
