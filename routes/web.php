<?php
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', function () {
    return redirect('/dashboard');
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/register', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::post('/logout', function () {
    return redirect('/login');
});