<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhitelistedEmail;

class WhitelistedEmailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:whitelisted_emails,email',
        ]);

        $whitelistedEmail = WhitelistedEmail::create([
            'email' => $request->input('email'),
        ]);

        return response()->json([
            'message' => 'Email successfully added to whitelist.',
            'data' => $whitelistedEmail,
        ], 201);
    }

    public function destroy($id)
    {
        $whitelistedEmail = WhitelistedEmail::find($id);

        if (!$whitelistedEmail) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        $whitelistedEmail->delete();

        return response()->json(['message' => 'Email successfully removed from whitelist']);
    }

}
