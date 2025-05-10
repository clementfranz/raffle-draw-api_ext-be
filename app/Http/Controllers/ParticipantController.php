<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    // Display a listing of participants.
    public function index()
    {
        $participants = Participant::all(); // Fetch all participants
        return response()->json($participants);
    }

    // Store a newly created participant in the database.
    public function store(Request $request)
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

        // Create a new participant
        $participant = Participant::create($validated);

        return response()->json($participant, 201); // Return the created participant
    }

    // Display the specified participant.
    public function show($id)
    {
        $participant = Participant::findOrFail($id); // Find participant by ID
        return response()->json($participant);
    }

    // Update the specified participant in the database.
    public function update(Request $request, $id)
    {
        $participant = Participant::findOrFail($id); // Find the participant to update

        // Validate the request
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

        // Update the participant
        $participant->update($validated);

        return response()->json($participant);
    }

    // Remove the specified participant from the database.
    public function destroy($id)
    {
        $participant = Participant::findOrFail($id); // Find the participant

        // Delete the participant
        $participant->delete();

        return response()->json(['message' => 'Participant deleted successfully']);
    }
}
