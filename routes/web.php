<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('transactions');
})->name('home');

Route::view('dashboard', 'dashboard_old')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
