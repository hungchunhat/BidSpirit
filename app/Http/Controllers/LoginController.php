<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        //validate
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //attempt to log in the user
        if (!Auth::attempt($validated)) {
            throw ValidationException::withMessages([
                'email' => ['No sorry, Incorrect Email or password.'],
            ]);
        };
        //regenerate the session token
        $request->session()->regenerate();
        //redirect
        return redirect('/');
    }

    public function destroy()
    {
        Auth::logout();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
