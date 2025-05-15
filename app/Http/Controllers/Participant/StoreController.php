<?php

namespace App\Http\Controllers\Participant;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
class StoreController extends Controller
{
    // Single participant creation
    public function __invoke(Request $request)
    {
        // Merge default values
        $request->merge([
            'is_drawn' => $request->input('is_drawn', true)
        ]);

        // Validate the request
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'id_entry' => 'required|integer',
            'raffle_code' => 'required|string|unique:participants,raffle_code|max:10',
            'regional_location' => 'required|string',
            'registered_at' => 'required|date',
            'is_drawn' => 'sometimes|boolean|default:false',
            'participant_batch_id' => 'sometimes|integer|default:1'
        ]);

        // Create the participant
        $participant = Participant::create($validated);

        return response()->json($participant, 201);
    }

    // Batch participant creation
    public function storeBatch(Request $request)
    {
        $entries = $request->input('payload');

        if (!is_array($entries)) {
            return response()->json(['error' => 'The "payload" field must be an array.'], 422);
        }

        $created = [];
        $errors = [];

        foreach ($entries as $index => $entry) {
            // Default values
            $entry['is_drawn'] = $entry['is_drawn'] ?? false;
            $entry['registered_at'] = $entry['registered_at'] ?? false;


            // If the date exists and is not already in a valid format
            if (!empty($entry['registered_at'])) {
                try {
                    $entry['registered_at'] = Carbon::parse($entry['registered_at'])->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $entry['registered_at'] = null; // or handle the error if needed
                }
            } else {
                $entry['registered_at'] = null;
            }


            $validator = Validator::make($entry, [
                'full_name' => 'required|string|max:255',
                'id_entry' => 'required|integer',
                'raffle_code' => 'required|string|unique:participants,raffle_code|max:10',
                'regional_location' => 'required|string',
                'registered_at' => 'required|date',
                'is_drawn' => 'required|boolean',
                'participant_batch_id' => 'sometimes|integer|default:1'
            ]);

            if ($validator->fails()) {
                $errors[$index] = $validator->errors()->messages();
                continue;
            }

            $created[] = Participant::create($validator->validated());
        }

        return response()->json([
            'created' => $created,
            'errors' => $errors
        ], 207); // Multi-Status
    }
}
