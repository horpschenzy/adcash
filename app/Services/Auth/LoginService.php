<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    public function login($request)
    {
        $credentials = $request->only(['email', 'password']);
        try {
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['status' => false, 'message' => 'Invalid Email or Password'], 401);
            }
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    
    public function me()
    {
        return response()->json(['status' => true, 'data' => auth()->user()], 200);

    }

   
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['status' => true, 'message' => 'Successfully logged out'], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => true,
            'message' => 'Login successfully',
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => auth()->user()
            ]
        ]);
    }
}
