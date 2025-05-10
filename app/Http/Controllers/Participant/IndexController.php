<?php

namespace App\Http\Controllers\Participant;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of all participants.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // You can apply pagination if needed, for large datasets
        $participants = Participant::all();

        return response()->json($participants);
    }
}
