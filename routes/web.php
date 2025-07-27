<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Jobs\SendWelcomeEmailJob;
use Carbon\Carbon;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function () {

$mailConfig = [
    'driver' => 'smtp',
    'host' => 'sandbox.smtp.mailtrap.io',
    'port' => 2525,
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'encryption' => 'tls',
];

dd('hapa');
// config(['mail' => $mailConfig]);
Mail::raw('This is a test email using Mailtrap!', function ($message) {
    $message->to('test@example.com')->subject('Test Email');
});

    $details['name'] = 'Md Obydullah';
    $details['email'] = 'hi@obydul.me';

    dispatch(new SendWelcomeEmailJob($details));

    dd('sent');
});

Route::get('/cert', [App\Http\Controllers\HomeController::class, 'generatePdf'])->name('generatePdf');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/events', [PostController::class, 'showDueDates'])->name('due_dates');
Route::get('/events/{id}/download-ics', function ($id) {
    $dummyEvents = [
        1 => [
            'title' => 'Math 101 Homework',
            'due_date' => Carbon::now()->addDays(3)->setHour(23)->setMinute(59),
            'description' => 'Complete exercises 1 to 10.',
        ],
        2 => [
            'title' => 'Physics Lab Report',
            'due_date' => Carbon::now()->addWeek()->setHour(17)->setMinute(0),
            'description' => 'Submit lab report on pendulum experiment.',
        ],
        3 => [
            'title' => 'English Essay',
            'due_date' => Carbon::now()->addDays(5)->setHour(20)->setMinute(0),
            'description' => 'Write an essay on modern poetry.',
        ],
    ];

    if (!isset($dummyEvents[$id])) {
        abort(404);
    }

    $event = $dummyEvents[$id];

    $icsContent = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//YourApp//EN
BEGIN:VEVENT
UID:{$id}@yourapp.com
DTSTAMP:" . now()->format('Ymd\THis\Z') . "
DTSTART:" . $event['due_date']->format('Ymd\THis\Z') . "
DTEND:" . $event['due_date']->copy()->addHour()->format('Ymd\THis\Z') . "
SUMMARY:{$event['title']}
DESCRIPTION:{$event['description']}
END:VEVENT
END:VCALENDAR";

    return response($icsContent, 200)
        ->header('Content-Type', 'text/calendar')
        ->header('Content-Disposition', 'attachment; filename="event-' . $id . '.ics"');
})->name('events.download-ics');

Route::get('/partners', [App\Http\Controllers\HomeController::class, 'partners'])->name('partners');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/chats', [App\Http\Controllers\HomeController::class, 'chats'])->name('chats');

Route::post('/comment', [App\Http\Controllers\HomeController::class, 'comment'])->name('comment');
