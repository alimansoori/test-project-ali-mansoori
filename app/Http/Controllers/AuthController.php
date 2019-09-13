<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => bcrypt($request->password),
         ]);

        // second param is minutes expire token
        $token = auth()->login($user, 2);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['name', 'email', 'password']);
        $token       = auth()->attempt($credentials, true, 2);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->expiresIn($token)
        ]);
    }
}
