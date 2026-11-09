<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
=======
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminManagementController;

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

// Logged-in student account routes & Dashboard
Route::middleware('auth.check')->group(function () {
    Route::get('/dashboard', function () {
        return session('is_admin')
            ? redirect()->route('attendance')
            : redirect()->route('student-attendance');
    })->name('dashboard');

    Route::get('/student-attendance', [AttendanceController::class, 'studentAttendance'])->name('student-attendance');
    Route::post('/student-attendance/record', [AttendanceController::class, 'recordOwnAttendance'])->name('student-attendance.record');
    Route::put('/student-attendance/profile', [AttendanceController::class, 'updateStudentProfile'])->name('student.profile.update');
});

// Admin & Super Admin Access (General Management & Users)
Route::middleware('admin')->group(function () {
    // Attendance logging & records
    Route::get('/attendance', [AttendanceController::class, 'create'])->name('attendance');
    Route::post('/attendance/record', [AttendanceController::class, 'recordAttendance'])->name('attendance.record');
    Route::get('/attendance/logs', [AttendanceController::class, 'logs'])->name('attendance.logs');

    // Student registration whitelisting
    Route::get('/register-student', [StudentController::class, 'create'])->name('register-student');
    Route::post('/register-student', [StudentController::class, 'store'])->name('register-student.submit');

   // General User Account Management (Registering both names so both views resolve successfully)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [AdminManagementController::class, 'edit'])->name('users.edit');
    Route::get('/users/{id}/edit', [AdminManagementController::class, 'edit'])->name('admin.edit');
    Route::put('/users/{id}', [AdminManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Super Admin Only (Managing Admin Accounts)
Route::middleware('admin')->group(function () {
    Route::get('/super-admin/admins', [AdminManagementController::class, 'index'])->name('admin.manage');
    Route::post('/super-admin/admins', [AdminManagementController::class, 'store'])->name('admin.store');
    Route::delete('/super-admin/admins/{id}', [AdminManagementController::class, 'destroy'])->name('admin.destroy');
});
>>>>>>> Stashed changes
