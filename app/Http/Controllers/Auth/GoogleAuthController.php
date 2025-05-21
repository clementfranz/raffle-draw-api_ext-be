<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\WhitelistedEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class GoogleAuthController extends Controller
{
    public function handleGoogleCallback(Request $request)
    {
        $email = $request->input('email');
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $sub = $request->input('sub');
        $picture = $request->input('picture');

        if (!$email || !$firstName || !$lastName) {
            return response()->json(['error' => 'Missing data from Google'], 422);
        }

        // Check if the email is whitelisted
        $isWhitelisted = WhitelistedEmail::where('email', $email)->exists();

        if (!$isWhitelisted) {
            return response()->json(['error' => 'Access denied. Email not whitelisted.'], 403);
        }

        // Check if user already exists
        $user = User::where('email', $email)->first();

        if ($user) {
            if (is_null($user->email_verified_at)) {
                $user->update([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'picture' => $picture,
                    'google_id' => $sub,
                    'provider' => 'google',
                    'email_verified_at' => Carbon::now(),
                ]);
            }

            $token = $user->createToken('google-auth')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user]);
        }

        // If user doesn't exist but is whitelisted, create an account
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => Hash::make('kopikoblanca'),
            'picture' => $picture,
            'google_id' => $sub,
            'provider' => 'google',
            'email_verified_at' => Carbon::now(),
        ]);

        $token = $user->createToken('google-auth')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $user]);
    }
}
