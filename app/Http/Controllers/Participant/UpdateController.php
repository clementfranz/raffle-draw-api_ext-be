<?php

namespace App\Http\Controllers\Participant;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    /**
     * Update the specified participant.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);

        $validated = $request->validate([
            'full_name_raw' => 'sometimes|string|max:255',
            'full_name_cleaned' => 'sometimes|string|max:255',
            'id_entry' => 'sometimes|integer',
            'raffle_code' => 'sometimes|string|max:10|unique:participants,raffle_code,' . $id,
            'regional_location' => 'sometimes|string',
            'registered_at' => 'sometimes|date',
            'uploaded_at' => 'sometimes|date',
            'is_drawn' => 'sometimes|boolean',
            'participant_batch_id' => 'sometimes|exists:participant_batches,id',
        ]);

        $participant->update($validated);

        return response()->json($participant);
    }
}
