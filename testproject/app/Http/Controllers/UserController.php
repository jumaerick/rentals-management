<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::with(['profile'])->get();
        // dd(User::all());
        return view('users.index', [
            'users' => User::Paginate(5)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        //
        // dd($request);
        $user = User::create($request->validated());
        $this->createProfile($user);
        // event(new Registered($user));

        return redirect()->route('home')->with('message', 'Account created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::leftjoin('profiles', 'users.id', '=', 'profiles.user_id')
        ->where('users.id', $id)
            ->first();
        return $user;
    }

    public function create()
    {
        return view('users.create');
    }

    public function edit($id)
    {
        //
        $user = User::where('id', $id)->first();

        // dd($user);
        return view('users.edit')->with(
            ['user'=>$user]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->validate([
            'location'=>'required',
            'phone_number' => 'required',
            'email' =>'email',
            'name' =>'required',
            
        ]
        );

        $user = User::where('id', $id)->first();

        if($user->email != $data['email']){
            $findUser  =  User::where('email', $data['email'])->first();
            if($findUser){
                    return back()->withErrors([
                        'email' => 'The email is already taken.',
                    ])->onlyInput('email');
            }
        }


        $user->name = $data['name'];
        $user->email = $data['email'];
        $this->updateProfile($data, $id);
        $user->save();
        return redirect()->route('user.index')->with('message', 'Details updated Successfully');

    }

    public function createProfile($user){
        $profile = new Profile;
        $profile->user_id = $user->id;
        $profile->save();
    }

    public function updateProfile($data, $u_id){
        $profile = Profile::where('user_id', $u_id)->first();
// dd($profile);
        $profile->phone_number = $data['phone_number'];
        $profile->location = $data['location'];
        $profile->save();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        // dd('hapa');
        User::find($request->id)->delete();
        return redirect()->route('user.list');
    }
}
