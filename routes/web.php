<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\TodoController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/todos', [TodoController::class, 'index'])->name('todo.index');
Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');