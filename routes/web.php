<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('transactions');
})->name('home');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('transactions');
})->name('dashboard');

Route::get('/logout', [UserController::class, 'logout']);

require __DIR__.'/settings.php';
