<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DateTimeZone;

class ProfileController extends Controller
{
    public function index() : View
    {
        $user = Auth::user();
        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

        return view('user.profile.index', compact('user', 'timezones')); 
    }

    public function update(Request $request, User $user) : RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:50',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'preferred_timezone' => 'required|string|timezone',
        ],[
            'name.regex' => 'The name may only contain letters and spaces.',
            'username.unique' => 'The username already taken.',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'preferred_timezone' => $request->preferred_timezone,
        ]);

        return redirect()->route('profile')->with('success', 'Profile Updated Successfully');
    }
}