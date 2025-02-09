<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $req) {
        $req->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:4|confirmed'
        ]);

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password)
        ]);

        return response()->json([
            'message' => 'Użytkownik zostal zarejestrowany',
            'user' => $user
        ], 201);   
    }

    public function login(Request $req) {
        $req->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($req->only('email', 'password'))) {
            return response()->json(['error' => 'Błędne dane logowania'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }
    public function getUser(Request $req) {
        return response()->json($req->user());
    }
    public function logout(Request $req) {
        $req->user()->tokens()->delete();
        return response()->json(['message' => 'Wylogowano pomyślnie.'], 200);
    }
}

