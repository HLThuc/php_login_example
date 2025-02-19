<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login($credentials)
    {
        return Auth::attempt($credentials);
    }

    public function isLoggedIn()
    {
        return Auth::check();
    }

    public function logout()
    {
        Auth::logout();
    }

    public function register($name, $email, $password)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        Auth::login($user);
    }
}