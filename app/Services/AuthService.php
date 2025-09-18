<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Http\Requests\UserLoginRequest;

class AuthService
{
    public function __construct() {}

    public function register(string $password, string $email, string $name): User
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        return $user;
    }

    public function login(string $password, string $email): User
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new Exception(__('message.incorrect'));
        }
        return $user;
    }
}
