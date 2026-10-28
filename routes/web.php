<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Employee\PortalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest pages
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Any logged-in user: /dashboard sends admins and employees to their home
|--------------------------------------------------------------------------
*/
Route::middleware('auth.check')->get('/dashboard', [AuthController::class, 'home'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin  (/admin/...)
|--------------------------------------------------------------------------
*/
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/attendance', [Admin\AttendanceController::class, 'create'])->name('attendance');
    Route::post('/attendance', [Admin\AttendanceController::class, 'record'])->name('attendance.record');
    Route::get('/logs', [Admin\AttendanceController::class, 'logs'])->name('logs');

    Route::get('/employees', [Admin\EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [Admin\EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [Admin\EmployeeController::class, 'store'])->name('employees.store');
});

/*
|--------------------------------------------------------------------------
| Employee Portal  (/employee/...)
|--------------------------------------------------------------------------
*/
Route::middleware('employee')->prefix('employee')->name('employee.')->group(function () {
    Route::get('/', [PortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/attendance', [PortalController::class, 'attendance'])->name('attendance');
    Route::get('/profile', [PortalController::class, 'profile'])->name('profile');
    Route::post('/clock', [PortalController::class, 'clock'])->name('clock');
});
