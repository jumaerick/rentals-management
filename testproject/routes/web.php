<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

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

Route::group(['prefix'=>'user','as'=>'user.'], function(){
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/create', [RegisterController::class, 'register'])->name('create');
});

// Route::get('/register', [RegisterController::class, 'create']);

// Route::prefix('/user');
// Route::get('/register', [RegisterController::class, 'show'])->name('register.form');
// Route::post('/create', [RegisterController::class, 'register'])->name('user.register');

