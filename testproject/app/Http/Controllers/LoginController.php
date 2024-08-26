<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    public function show()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {

            // if (!Auth::user()->email_verified_at) {
            //     return back()->withErrors([
            //         'email' => 'Your Account is not activated.',
            //     ])->onlyInput('email');
            // }

            $request->session()->regenerate();
            return redirect('home')->with('message', 'Login Successfully');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
