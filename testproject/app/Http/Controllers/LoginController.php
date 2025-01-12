<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=> 'required|min:8',
        ]);

        // dd($credentials);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {

            // if (!Auth::user()->email_verified_at) {
            //     return back()->withErrors([
            //         'email' => 'Your Account is not activated.',
            //     ])->onlyInput('email');
            // }
  
            $request->session()->regenerate();
            if(Auth::user()->role->name=='registered_user'){
                return redirect('/home')->with('message', 'Login Successfully');
            }

            return redirect('/dashboard')->with('message', 'Login Successfully');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
