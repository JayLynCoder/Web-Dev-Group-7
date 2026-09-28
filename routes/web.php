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

Route::post('/logout', function () {
    session()->flush();

    return redirect()->route('login');
})->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard', ['members' => config('members')]);
});

Route::get('/members/{slug}', function ($slug) {
    $members = config('members');

    abort_unless(array_key_exists($slug, $members), 404);

    return view('members.' . $slug, [
        'members' => $members,
        'name'    => $members[$slug],
    ]);
})->name('members.show');