<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DateTimeZone;

class AuthController extends Controller
{   
    public function showLoginForm() : View
    {
        return view('auth.login');
    }

    public function login(Request $request) : RedirectResponse
    {
        $data = $request->validate([
            'username' => 'required|string|exists:users,username',
        ],[
             'username.exists' => 'This username not found.',
        ]);

        $user = User::where('username', $data['username'])->first();
        Auth::login($user);
        session(['last_activity_time' => time()]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request) : RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }

    public function showRegisterForm() : View
    {
        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

        return view('auth.register', compact('timezones'));
    }

    public function register(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:50',
            'username' => 'required|string|max:50|unique:users,username',
            'preferred_timezone' => 'required|string|timezone',
        ],[
            'name.regex' => 'The name may only contain letters and spaces.',
            'username.unique' => 'This username already taken.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'preferred_timezone' => $request->preferred_timezone,
        ]);
        
        Auth::login($user);
        session(['last_activity_time' => time()]);

        return redirect()->route('dashboard')->with('success','Account created successfully.');
    }
}