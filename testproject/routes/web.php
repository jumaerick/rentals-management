<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomAssignmentController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\PaymentController;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/register', [RegisterController::class, 'show'])->name('register.form');
    Route::post('/create', [RegisterController::class, 'register'])->name('create');
    Route::get('/login', [LoginController::class, 'show'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::get('/index', [UserController::class, 'index'])->name('list');
    Route::post('/delete', [UserController::class, 'destroy'])->name('destroy');
    Route::post('/update', [UserController::class, 'update'])->name('update');
});

Route::get('password/reset', function () {
    return view('auth.passwords.email');
})->name('password.request');

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('password/reset/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->name('password.reset');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
// Route::post('/forgot-password/{token}', [ForgotPasswordController::class, 'reset']);

Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth')->name('logout');

Route::group(['prefix' => 'company', 'as' => 'company.'], function () {
    Route::get('/create', [CompanyController::class, 'create'])->name('form');
    Route::post('/create', [CompanyController::class, 'store'])->name('store');
    Route::get('/index', [CompanyController::class, 'index'])->name('list');
    Route::post('/delete', [CompanyController::class, 'destroy'])->name('destroy');
    Route::post('/update', [CompanyController::class, 'update'])->name('update');
    Route::get('/{company}', [CompanyController::class, 'show'])->name('show');
    Route::get('/properties/{company}', [CompanyController::class, 'properties'])->name('properties');
    // Route::post('/login', [CompanyController::class, 'login'])->name('login');
});

Route::group(['prefix' => 'property', 'as' => 'property.'], function () {
    Route::get('/create', [PropertyController::class, 'create'])->name('form');
    Route::post('/create', [PropertyController::class, 'store'])->name('store');
    Route::get('/index', [PropertyController::class, 'index'])->name('list');
    Route::post('/delete', [PropertyController::class, 'destroy'])->name('destroy');
    Route::get('/{property}', [PropertyController::class, 'show'])->name('show');
    Route::post('/update', [PropertyController::class, 'update'])->name('update');
    Route::get('/rooms/{property}', [PropertyController::class, 'rooms'])->name('rooms');
    // Route::post('/login', [CompanyController::class, 'login'])->name('login');
});

Route::group(['prefix' => 'room', 'as' => 'room.'], function () {
    Route::get('/create', [RoomController::class, 'create'])->name('form');
    Route::post('/create', [RoomController::class, 'store'])->name('store');
    Route::get('/index', [RoomController::class, 'index'])->name('list');
    Route::post('/delete', [RoomController::class, 'destroy'])->name('destroy');
    Route::post('/update', [RoomController::class, 'update'])->name('update');
    // Route::post('/login', [CompanyController::class, 'login'])->name('login');
});


Route::group(['prefix' => 'rent', 'as' => 'rent.'], function () {
    Route::get('/create', [RentController::class, 'create'])->name('form');
    Route::post('/create', [RentController::class, 'store'])->name('store');
    Route::get('/index', [RentController::class, 'index'])->name('list');
    Route::post('/delete', [RentController::class, 'destroy'])->name('destroy');
    Route::post('/update', [RentController::class, 'update'])->name('update');
    // Route::post('/login', [CompanyController::class, 'login'])->name('login');
});

Route::group(['prefix' => 'payment', 'as' => 'payment.'], function () {
    Route::get('/create', [PaymentController::class, 'create'])->name('form');
    Route::post('/create', [PaymentController::class, 'store'])->name('store');
    Route::get('/index', [PaymentController::class, 'index'])->name('list');
    Route::post('/delete', [PaymentController::class, 'destroy'])->name('destroy');
    Route::post('/update', [PaymentController::class, 'update'])->name('update');
    // Route::post('/login', [CompanyController::class, 'login'])->name('login');
});

Route::group(['prefix' => 'roomAssignment', 'as' => 'roomAssignment.'], function () {
    Route::get('/create', [RoomAssignmentController::class, 'create'])->name('form');
    Route::post('/create', [RoomAssignmentController::class, 'store'])->name('store');
    Route::get('/index', [RoomAssignmentController::class, 'index'])->name('list');
    Route::post('/delete', [RoomAssignmentController::class, 'destroy'])->name('destroy');
    Route::post('/update', [RoomAssignmentController::class, 'update'])->name('update');
    // Route::post('/login', [CompanyController::class, 'login'])->name('login');
});


