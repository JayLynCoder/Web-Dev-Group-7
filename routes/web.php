<?php

use Illuminate\Support\Facades\Route;

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

Route::post('/logout', function () {
    session()->flush();

    return redirect()->route('login');
})->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/record', function () {
    return view('record');
})->name('record');

Route::get('/attendance', function () {
    return view('attendance');
})->name('attendance');