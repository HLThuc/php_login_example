<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\AuthService;

class AuthController extends Controller
{
    private $AuthService;

    public function __construct(AuthService $AuthService) {
        $this->AuthService = $AuthService;
    }
    
    public function home() {
        return redirect('/login');
    }

    public function showLoginForm()
    {
        if ($this->AuthService->isLoggedIn()) {
            return redirect('/hello');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($this->AuthService->login($credentials)) {
            return redirect()->intended('/hello');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        $this->AuthService->logout();
        return redirect('/login');
    }

    public function showRegisterForm()
    {
        if ($this->AuthService->isLoggedIn()) {
            return redirect('/hello');
        }
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);
        $this->AuthService->register(
            $request->name,
            $request->email,
            $request->password,
        );
        return redirect('/hello');
    }
}
