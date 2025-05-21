<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\WhitelistedEmail;

class EmailAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = $request->email;
        $password = $request->password;

        // Check if user already exists
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Check if the email is whitelisted
            $whitelisted = WhitelistedEmail::where('email', $email)->first();

            if (!$whitelisted) {
                return response()->json(['error' => 'User not found.'], 404);
            }

            // Create new user using whitelisted data
            $user = User::create([
                'email' => $email,
                'first_name' => $whitelisted->first_name ?? 'New User',
                'last_name' => $whitelisted->last_name ?? 'From Kopiko',
                'password' => Hash::make('kopikoblanca'),
                'email_verified_at' => now(),
                'provider' => 'email',
            ]);
        }

        // Verify password
        if (!Hash::check($password, $user->password)) {
            return response()->json(['error' => 'Incorrect password.'], 401);
        }

        // Generate token
        $token = $user->createToken('email-auth')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
