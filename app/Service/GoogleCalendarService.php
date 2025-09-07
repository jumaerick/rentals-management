<?php 

namespace App\Service; 
use Google\Client; 
use Illuminate\Support\Facades\Auth;
use Google\Service\Calendar; 

class GoogleCalendarService {    
	protected $client;    
	protected $calendarService;    
	
	public function __construct() {      
		$this->client = new Client();        
		$this->client->setClientId(config('services.google.client_id'));        
		$this->client->setClientSecret(config('services.google.client_secret'));    
		// dd(config('services.google.redirect'));  
		$this->client->setRedirectUri(config('services.google.redirect')); 
		$this->client->setAccessType('offline');  
        // $this->client->setState('calendar');
        // $this->client->setPrompt('consent');
     
		$this->client->addScope(Calendar::CALENDAR); 
        // dd($this);
    // $user = Auth::user();

    // if ($user && $user->google_access_token) {
    //     $this->client->setAccessToken($user->google_access_token);

    //     if ($this->client->isAccessTokenExpired()) {
    //         $newToken = $this->client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);

    //         $user->google_access_token = $newToken['access_token'];
    //         $user->google_token_expires_at = now()->addSeconds($newToken['expires_in']);
    //         $user->save();

    //         $this->client->setAccessToken($newToken); // update client with new token
    //     }
    // }      
    // dd('hapa'); 
		$this->calendarService = new Calendar($this->client);    
	}    
	
	public function authenticate($code) {   
// dd($code);
		if (!auth()->user()->google_refresh_token) {
    // First-time connection: ask for consent to get refresh token
    		$this->client->setPrompt('consent');
		}     
		$accessToken = $this->client->fetchAccessTokenWithAuthCode($code); 
		// dd($accessToken['access_token']);  
		$user = auth()->user();
		// dd($user);
		$user->google_access_token = $accessToken['access_token'];
    
    // Save refresh token only if provided (first-time auth)
    if (isset($accessToken['refresh_token'])) {
        $user->google_refresh_token = $accessToken['refresh_token'];
    }

    $user->google_token_expires_at = now()->addSeconds($accessToken['expires_in']);
    $user->save();
	session(['google_access_token' => $this->client->getAccessToken()]);  
    return $accessToken;
  
	}    
	
	public function getClient()  {        
		if (session('google_access_token')) {            
			$this->client->setAccessToken(session('google_access_token'));        
		}        
		
		return $this->client;    
	}    
	
	public function listEvents($calendarId = 'primary')  {       
		$this->getClient();        
		$events = $this->calendarService->events->listEvents($calendarId);        
		return $events->getItems();    
	}    
	
	public function createEvent($eventData, $calendarId = 'primary')  {        
		$this->getClient();        
		$event = new \Google\Service\Calendar\Event($eventData);        
		$event = $this->calendarService->events->insert($calendarId, $event);
		
		// You can also insert the event in DB to retrieve it from there later        
		return $event;    
	} 
}