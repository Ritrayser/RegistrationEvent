<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Hash;
use League\Config\Exception\ValidationException;

class AuthController extends Controller
{

    public function register (UserRegisterRequest $request)
{
 $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
         ]);


    $token = $user->createToken('auth_token');

    return response()->json(['token' => $token->plainTextToken], 201);
}

    public function login (UserLoginRequest $request)
{
 $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Указанные данные неверны.'],
        ]);
    }

    $token = $user->createToken('default');

    return response()->json(['token' => $token->plainTextToken], 200);
}
    
}
