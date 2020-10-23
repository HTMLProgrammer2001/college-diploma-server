<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserActions\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActions extends Controller
{
    public function login(LoginRequest $request){
        $credentials = $request->only(['email', 'password']);

        if(!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Wrong email or password'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->getToken();

        return response()->json([
            'token' => $token,
            'user' => new UserResource($user),
            'message' => 'User was successfully logged in'
        ], 200);
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->token()->revoke();

        return response()->json([
            'message' => 'User was successfully logged out'
        ], 200);
    }

    public function getMe(){
        $user = auth('api')->user();

        return response()->json([
           'user' => $user ? new UserResource($user) : null
        ]);
    }
}
