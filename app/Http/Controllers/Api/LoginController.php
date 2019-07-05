<?php

namespace App\Http\Controllers\Api;

use JWTAuth;
use JWTAuthException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = null;

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'result' => 'error',
                    'message' => 'invalid_credentials'
                ]);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'result' => 'error',
                'message' => 'server_error: ' . $e->getMessage()
            ]);
        }
        return response()->json([
            'result' => 'success',
            'token' => $token
        ]);
    }

    public function me(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
    }
}
