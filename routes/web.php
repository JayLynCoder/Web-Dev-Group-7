<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;

Route::get('/', fn () => redirect()->route('login'));

// Registration
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Any logged-in user
Route::middleware('auth.check')->group(function () {
    Route::get('/dashboard', function () {
        return session('is_admin')
            ? redirect()->route('attendance')
            : redirect()->route('student-attendance');
    })->name('dashboard');

    Route::get('/student-attendance', [AttendanceController::class, 'studentAttendance'])->name('student-attendance');
    Route::post('/student-attendance/record', [AttendanceController::class, 'recordOwnAttendance'])->name('student-attendance.record');
});

// Admin only
Route::middleware('admin')->group(function () {
    // Attendance login + logs
    Route::get('/attendance', [AttendanceController::class, 'create'])->name('attendance');
    Route::post('/attendance/record', [AttendanceController::class, 'recordAttendance'])->name('attendance.record');
    Route::get('/attendance/logs', [AttendanceController::class, 'logs'])->name('attendance.logs');

    // Student registration
    Route::get('/register-student', [StudentController::class, 'create'])->name('register-student');
    Route::post('/register-student', [StudentController::class, 'store'])->name('register-student.submit');

    // User account management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});