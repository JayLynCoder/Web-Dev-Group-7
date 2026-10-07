<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;

Route::get('/', fn () => redirect()->route('login'));

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Logged-in users
Route::middleware('auth.check')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::get('/attendance', [AttendanceController::class, 'create'])->name('attendance');
    Route::post('/attendance/record', [AttendanceController::class, 'recordAttendance'])->name('attendance.record');
});

// Admin only
Route::middleware('admin')->group(function () {
    Route::get('/register-employee', [EmployeeController::class, 'create'])->name('register-employee');
    Route::post('/register-employee', [EmployeeController::class, 'store'])->name('register-employee.submit');
});