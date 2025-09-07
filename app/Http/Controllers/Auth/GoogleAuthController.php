<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PersonalAccess;
use App\Service\GoogleCalendarService; 
use Throwable;

class GoogleAuthController extends Controller
{
    protected $googleService;    
	public function __construct(GoogleCalendarService $googleService)  {        
		$this->googleService = $googleService;    
	}   
    //Redirect to google auth page
    public function redirect() {
        session(['auth_flow' => 'sso']);
        return Socialite::driver('google')
            // ->with(['state_name' => 'sso'])
            ->redirect();
    }


    //Handle google authentication callback

    public function handleCallback(Request $request)
{
    // $state_name = $request->input('state_name');
    // $state = $request->input('state');
    // dd($state);
    $flow = session('auth_flow');
    // dd($flow);

    if ($flow == 'calendar') {
        return $this->handleGoogleCalendarCallback($request);
    } elseif ($flow == 'sso') {
        return $this->callback($request);
    }
    // session('auth_flow')->forget();
    // dd(session()->all());
        // return $this->callback($request);

}

    public function callback(Request $request){
        // dd($request);
        // dd(session('auth_flow'));
        try {
            // Get the user information from Google
            $user = Socialite::driver('google')->user();
            // dd($user);

        } catch (Throwable $e) {
            return redirect('/')->with('error', 'Google authentication failed.');
        }
        // Check if the user already exists in the database
        $existingUser = User::where('email', $user->email)->first();
        // dd($existingUser);

        // dd($existingUser)
        if ($existingUser) {
            // Log the user in if they already exist
            Auth::login($existingUser);
        } else {
            // Otherwise, create a new user and log them in
            $newUser = User::updateOrCreate([
                'email' => $user->email
            ], [
                'name' => $user->name,
                'password' => bcrypt(Str::random(16)), // Set a random password
                'email_verified_at' => now()
            ]);
            session()->forget('auth_flow');

            Auth::login($newUser);
        }

        session()->forget('auth_flow');

        // Redirect the user to the dashboard or any other secure page
        return redirect('/dashboard');

    }


        public function handleGoogleCalendarCallback(Request $request){
// dd($request->get('code'));
		$googleUser = $this->googleService->authenticate($request->get('code'));
		// $user = auth()->user();
		// dd($user);
		// $user->google_access_token = $googleUser['access_token'];
		// $user->google_refresh_token = $googleUser['refresh_token'] ?? $user->google_refresh_token;
		// $user->google_token_expires_at = now()->addSeconds($googleUser['expires_in']);
		// $user->save(); 
		 session(['google_calendar_connected' => true]);   
         
		return redirect('/events')->with('success', 'Google Calendar connected!');    
        // Redirect the user to the dashboard or any other secure page
        // return redirect('/dashboard');

    }
    
}
