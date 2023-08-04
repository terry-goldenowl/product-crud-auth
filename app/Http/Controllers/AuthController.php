<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function register(Request $request): RedirectResponse
    {
        // dd($request);
        $request->validate([
            "name" => ['required', 'string', 'max:50'],
            "email" => ['required', 'string', 'email', 'unique:' . User::class],
            "password" => ['required', 'confirmed', 'min:8', 'max:30', Rules\Password::defaults()]
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function login(Request $request): RedirectResponse
    {
        // dd($request);
        $credentials = $request->validate([
            "email" => ['required', 'string', 'email'],
            "password" => ['required', 'min:8', 'max:30']
        ]);

        // Remember me!
        $remember = $request->has("remember");

        if (Auth::attempt($credentials, $remember)) {
            return to_route('home');
        }

        return back()->withErrors(['message' => 'These credentials do not match any user!']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('login');
    }
}
