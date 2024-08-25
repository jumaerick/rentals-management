<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Auth\Events\Registered;


use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    //

    public function show(){
        return view('auth.register');
    }

    
    public function register(RegisterRequest $request){

        // dd($request);
        $user = User::create($request->validated());
        $this->createProfile($user);
        event(new Registered($user));

        return view('home')->with('message', 'Account created Successfully');
    }

    public function createProfile($user){
        $profile = new Profile;
        $profile->user_id = $user->id;
        $profile->save();
    }

}
