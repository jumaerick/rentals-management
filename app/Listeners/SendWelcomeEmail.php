<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Models\User;
use App\Jobs\SendWelcomeEmailJob;
use App\Mail\WelcomeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWelcomeEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentCreated $event): void
    {
        //
        // $subscribers = User::all();
    

        // foreach ($subscribers as $subscriber) {
        //     dispatch(new SendWelcomeEmailJob([
        //         'email' => $subscriber->email,
        //         'name' => $subscriber->name,
        //     ]));
        // }

        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                dispatch(new SendWelcomeEmailJob($user));
            }
        });
        
    }
}
