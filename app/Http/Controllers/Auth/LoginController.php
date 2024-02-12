<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function createUser(Request $request) {
        try {
            $validatedUser = $request->validate([
                'name' => 'required',
                'email' => 'required|string|email', 
                'password' => 'required|string', 
            ]);
            
            $user = User::create([
                'name' => $validatedUser['name'],
                'email' => $validatedUser['email'],
                'password' => Hash::make($validatedUser['password']),
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'User created successfully', 
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->errors()
            ], 500);
        }
    }

    public function loginUser(Request $request) {

        $credentials = $request->validate([
            'email' => 'required|email', 
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'The provided credentials do not match our records.',
            ], 401);
        }
    
        $user = Auth::user(); 

        $token = $user->createToken("API TOKEN")->plainTextToken;
    
        return response()->json([
            'status' => true,
            'message' => 'User logged in successfully',
            'token' => $token
        ], 200);
    }

    public function logoutUser(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
