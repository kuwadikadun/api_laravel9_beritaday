<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
     
        $user = User::where('email', $request->email)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
     
        return $user->createToken('user login')->plainTextToken;    
    }

    public function logout(User $user)
    {
        // $request->user->currentAccessToken()->delete();

        $user = User::find(Auth::user()->id);

        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Logout'
        ]);

        // $user->tokens()->where('id', Auth::user()->id)->delete();
    }

    public function me(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Its me',
            'data' => Auth::user()
        ]);
    }
}
