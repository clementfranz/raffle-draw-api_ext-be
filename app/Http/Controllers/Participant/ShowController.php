<?php

namespace App\Http\Controllers\Participant;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    /**
     * Display the specified participant.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
        $participant = Participant::findOrFail($id);

        return response()->json($participant);
    }
}
