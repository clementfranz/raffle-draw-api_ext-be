<?php
namespace App\Http\Controllers\WinnerParticipant;

use App\Models\WinnerParticipant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    /**
     * Display the specified participant by ID.
     */
    public function show($id)
    {
        $participant = WinnerParticipant::findOrFail($id);

        return response()->json($participant);
    }

       /**
     * Return all winner participants' raffle codes only.
     */
    public function getAllRaffleCodesOnly()
    {
        $raffleCodes = WinnerParticipant::pluck('raffle_code');

        return response()->json($raffleCodes);
    }

    /**
     * Return a single winner participant by raffle code.
     */
    public function getSingleViaRaffleCode($raffleCode)
    {
        $participant = WinnerParticipant::where('raffle_code', $raffleCode)->firstOrFail();

        return response()->json($participant);
    }


    public function count()
    {
        $total = WinnerParticipant::count();

        return response()->json(['total' => $total]);
    }

}
