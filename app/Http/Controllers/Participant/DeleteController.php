<?php

namespace App\Http\Controllers\Participant;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    /**
     * Delete a single participant by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
        $participant = Participant::find($id);

        if (!$participant) {
            return response()->json(['message' => 'Participant not found'], 404);
        }

        $participant->delete();

        return response()->json(['message' => 'Participant deleted successfully']);
    }

    /**
     * Delete all participants.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll()
    {
        Participant::truncate(); // Fast and efficient for deleting all records

        return response()->json(['message' => 'All participants deleted successfully']);
    }
}
