<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Service\GoogleCalendarService; 
use Illuminate\Http\Request;
use Carbon;

class GoogleCalendarController extends Controller
{
    //
    protected $googleService;    
	public function __construct(GoogleCalendarService $googleService)  {        
		$this->googleService = $googleService;    
	}    

    public function redirectToGoogle(){
        // dd('hapa');
        session(['auth_flow' => 'calendar']);
        // dd($this->googleService->getClient()->createAuthUrl());

		return redirect()->away($this->googleService->getClient()->createAuthUrl());   
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
         
		return redirect('/dashboard')->with('success', 'Google Calendar connected!');    
        // Redirect the user to the dashboard or any other secure page
        // return redirect('/dashboard');

    }

    public function showEvents() {    
        // dd(session()->has('google_calendar_connected'));
        dd(auth()->user());
    if(!session()->has('google_calendar_connected')){
        return redirect()->route('auth.calendar.redirect');
    }

	$events = $this->googleService->listEvents();    
	return view('events.index', compact('events'));         

    }

    public function storeEvent(Request $request) {    
    $eventData = [
        'summary' => $request->input('summary'),
        'start' => [
            'dateTime' => Carbon::parse($request->input('start'))->toIso8601String(),
            'timeZone' => 'UTC', // or any valid IANA time zone
        ],
        'end' => [
            'dateTime' => Carbon::parse($request->input('end'))->toIso8601String(),
            'timeZone' => 'UTC',
        ],
    ];
	
	$event = $this->googleService->createEvent($eventData);    
	return redirect()->back()->with('success', 'Event created: ' . $event->getSummary()); 
}


}


// <?php 

// namespace App\Http\Controllers; 

// use App\Services\GoogleCalendarService; 
// use Illuminate\Http\Request; 
// use Carbon\Carbon;

// class GoogleCalendarController extends Controller {    
// 	protected $googleService;    
// 	public function __construct(GoogleCalendarService $googleService)  {        
// 		$this->googleService = $googleService;    
// 	}    
	
// 	public function redirectToGoogle()  {        
// 		return redirect()->away($this->googleService->getClient()->createAuthUrl());    
// 	}    
	
// 	public function handleGoogleCallback(Request $request)  {        
// 		$googleUser = $this->googleService->authenticate($request->get('code'));
// 		// $user = auth()->user();
// 		// dd($user);
// 		// $user->google_access_token = $googleUser['access_token'];
// 		// $user->google_refresh_token = $googleUser['refresh_token'] ?? $user->google_refresh_token;
// 		// $user->google_token_expires_at = now()->addSeconds($googleUser['expires_in']);
// 		// $user->save(); 
// 		 session(['google_calendar_connected' => true]);    
// 		return redirect('/events')->with('success', 'Google Calendar connected!');    
// 	} 

//     public function showEvents() {    
// // dd(session()->has('google_calendar_connected'));
// 	$events = $this->googleService->listEvents();    
// 	return view('events.index', compact('events')); 
//     }

//     public function storeEvent(Request $request) {    
//     $eventData = [
//         'summary' => $request->input('summary'),
//         'start' => [
//             'dateTime' => Carbon::parse($request->input('start'))->toIso8601String(),
//             'timeZone' => 'UTC', // or any valid IANA time zone
//         ],
//         'end' => [
//             'dateTime' => Carbon::parse($request->input('end'))->toIso8601String(),
//             'timeZone' => 'UTC',
//         ],
//     ];
	
// 	$event = $this->googleService->createEvent($eventData);    
// 	return redirect()->back()->with('success', 'Event created: ' . $event->getSummary()); }
// }