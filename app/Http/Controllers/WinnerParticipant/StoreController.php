<?php

namespace App\Http\Controllers\WinnerParticipant;

use App\Models\WinnerParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->input('payload', []);

        // Defaults / computed fields
        $data['is_drawn'] = $data['is_drawn'] ?? true;
        $data['participant_batch_id'] = 1;
        $data['full_name_raw'] = $data['full_name_raw'] ?? '';
        $data['full_name_cleaned'] = $data['full_name_cleaned'] ?? $data['full_name'] ?? '';
        $data['has_won'] = true;
        $data['won_at'] = now();

        $validator = Validator::make($data, [
            'participant_id' => 'nullable|exists:participants,id',
            'old_participant_id' => 'nullable|integer',
            'full_name_raw' => 'required|string|max:255',
            'full_name_cleaned' => 'nullable|string|max:255',
            'id_entry' => 'required|integer',
            'raffle_code' => 'required|string|unique:winner_participants,raffle_code|max:20',
            'regional_location' => 'nullable|string|max:255',
            'registered_at' => 'nullable|date',
            'uploaded_at' => 'nullable|date',
            'is_drawn' => 'required|boolean',
            'drawn_at' => 'nullable|date',
            'participant_batch_id' => 'required|integer|exists:participant_batches,id',
            'has_won' => 'required|boolean',
            'won_at' => 'required|date',
            'winner_type' => 'nullable|string|max:255',
            'is_cancelled' => 'boolean',
            'cancelled_at' => 'nullable|date',
            'is_proclaimed' => 'boolean',
            'proclaimed_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $participant = WinnerParticipant::create($validated);

        return response()->json($participant, 201);
    }
}
