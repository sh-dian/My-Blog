<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request ){

        $validated = $request->validated();

        if (Auth::attempt($validated, true)) {
            $user = Auth::user();
            $user->access_token =  $user->createToken('authToken')->plainTextToken;
            return $this->return_api(true, Response::HTTP_OK, null, new UserResource($user), null);
        } else {
            return $this->return_api(false, Response::HTTP_UNAUTHORIZED, trans("auth.failed"), null, null);
        }
    }

    public function logout()
    {
        // Revoke all tokens...
        $user = Auth::user()->tokens()->delete();

        return $this->return_api(true, Response::HTTP_OK, null, null, null);
    }
}
