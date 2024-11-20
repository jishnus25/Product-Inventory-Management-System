<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

    
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = User::find(Auth::id()); 
            $token = $user->createToken('auth_token')->plainTextToken;
        
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
            ]);
        }
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        
        if ($request->user()) {
            $request->user()->tokens()->delete();
            session()->flush();
            session()->invalidate();
            return response()->json(['message' => 'Logged out successfully']);
        }
        return response()->json(['message' => 'No active session found'], 401);
    }
    
    
}

