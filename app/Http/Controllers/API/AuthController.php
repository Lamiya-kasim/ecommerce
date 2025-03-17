<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // User Login
    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // Find user manually
    $user = User::where('email', $request->email)->first();
    
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Check password manually
    if (!Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Invalid password'], 401);
    }

    // Check if email is verified
    if ($user->email_verified_at === null) {
        return response()->json(['error' => 'Email not verified'], 403);
    }

    // Generate token
    $token = $user->createToken('auth_token')->accessToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ], 200);
}

    // User Logout
    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete(); // Revoke all tokens
            return response()->json(['message' => 'Successfully logged out'], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Get User Profile
    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ], 200);
    }
}

