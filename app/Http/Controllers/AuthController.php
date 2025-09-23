<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function register(UserRegisterRequest $request, AuthService $authService)
    {

        $user = $authService->register(name: $request->name, password: $request->password, email: $request->email);

        $token = $user->createToken('auth_token');

        return response()->json(['token' => $token->plainTextToken], 201);
    }

    public function login(UserLoginRequest $request, AuthService $authService)
    {
        $user = $authService->login(password: $request->password, email: $request->email);

        $token = $user->createToken('default');

        return response()->json(['token' => $token->plainTextToken], 200);
    }
}
