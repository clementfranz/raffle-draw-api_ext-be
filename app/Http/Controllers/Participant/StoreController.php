<?php

namespace App\Http\Controllers\Participant;


use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class StoreController extends Controller
{
    // Single participant creation
    public function __invoke(Request $request)
    {
        // Merge default values before validation
        $request->merge([
            'is_drawn' => $request->input('is_drawn', true),
            'participant_batch_id' => $request->input('participant_batch_id', 1),
        ]);

        // Validate the request
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'id_entry' => 'required|integer',
            'raffle_code' => 'required|string|unique:participants,raffle_code|max:10',
            'regional_location' => 'required|string',
            'registered_at' => 'required|date',
            'is_drawn' => 'sometimes|boolean',
            'participant_batch_id' => 'sometimes|integer',
        ]);

        // Create the participant
        $participant = Participant::create($validated);

        return response()->json($participant, 201);
    }

    // Batch participant creation
    // Batch participant creation
    public function storeBatch(Request $request)
    {
        $entries = $request->input('payload');

        if (!is_array($entries)) {
            return response()->json(['error' => 'The "payload" field must be an array.'], 422);
        }

        $prepared = [];
        $errors = [];

        foreach ($entries as $index => $entry) {
            // Default values
            $entry['is_drawn'] = filter_var($entry['is_drawn'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $entry['participant_batch_id'] = $entry['participant_batch_id'] ?? 1;

            // Validate (ignoring unique raffle_code at this level)
            $validator = Validator::make($entry, [
                'full_name' => 'required|string|max:255',
                'id_entry' => 'required|integer',
                'raffle_code' => 'required|string|max:10',
                'regional_location' => 'required|string',
                'registered_at' => 'required|date',
                'is_drawn' => 'required|boolean',
                'participant_batch_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                $errors[$index] = $validator->errors()->messages();
                continue;
            }

            $validated = $validator->validated();
            $validated['created_at'] = now();
            $validated['updated_at'] = now();

            $prepared[] = $validated;
        }

        // Chunked upsert to avoid too many placeholders
        if (!empty($prepared)) {
            collect($prepared)
                ->chunk(2500)
                ->each(function ($chunk) {
                    Participant::upsert(
                        $chunk->all(),
                        ['raffle_code'], // Ensure this is UNIQUE in the DB schema!
                        []               // Skip updating on conflict
                    );
                });
        }

        return response()->json([
            'inserted_count' => count($prepared),
            'skipped_count' => count($errors),
            'errors' => $errors,
        ], 207); // Multi-status response
    }





}
