<?php
namespace App\Http\Controllers\Participant;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    /**
     * Display the specified participant by ID.
     */
    public function show($id)
    {
        $participant = Participant::findOrFail($id);

        return response()->json($participant);
    }

    /**
     * Display paginated participants.
     */
    public function paginate($page, $size)
    {
        $total = Participant::count();
        $participants = Participant::skip(($page - 1) * $size)
                                    ->take($size)
                                    ->get()
                                    ->makeHidden(['id']); // 👈 hide 'id' from each item

        return response()->json([
            'data' => $participants,
            'meta' => [
                'current_page' => (int) $page,
                'per_page' => (int) $size,
                'total' => $total,
                'total_pages' => ceil($total / $size),
            ],
        ]);
    }

    /**
     * Count total participants.
     */
    public function count()
    {
        $total = Participant::count();

        return response()->json(['total' => $total]);
    }

    /**
     * Get the date of the latest participant.
     */
    public function getLatestParticipantDate()
    {
        $latest = Participant::latest()->first();

        if (!$latest) {
            return response()->json(['date' => null]);
        }

        $dateOnly = $latest->created_at->toDateString(); // format: 'YYYY-MM-DD'

        return response()->json(['date' => $dateOnly]);
    }
}
