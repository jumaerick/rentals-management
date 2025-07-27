<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Jobs\SendWelcomeEmailJob;

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

Route::get('/partners', [App\Http\Controllers\HomeController::class, 'partners'])->name('partners');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/chats', [App\Http\Controllers\HomeController::class, 'chats'])->name('chats');

Route::post('/comment', [App\Http\Controllers\HomeController::class, 'comment'])->name('comment');
