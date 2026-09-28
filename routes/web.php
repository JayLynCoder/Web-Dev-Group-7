<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('dashboard');
})->name('login.submit');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function () {
    return redirect()
        ->route('register')
        ->with('registration_success', true);
})->name('register.submit');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::post('/logout', function () {
    session()->flush();

    return redirect()->route('login');
})->name('logout');