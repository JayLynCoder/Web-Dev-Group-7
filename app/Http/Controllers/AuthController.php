<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'student_number' => 'required|string|exists:students,student_number',
            'username'       => 'required|string|max:100|unique:users,username',
            'email'          => 'required|email|max:255|unique:users,email',
            'password'       => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ], [
            'student_number.exists' => 'No student with that student number was found. Ask an admin to whitelist you first.',
        ]);

        $student = Student::where('student_number', $validated['student_number'])->firstOrFail();

        if (User::where('student_id', $student->id)->exists()) {
            return back()
                ->withErrors(['student_number' => 'This student number already has an account.'])
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user = new User();
        $user->username      = $validated['username'];
        $user->email         = $validated['email'];
        $user->password_hash = Hash::make($validated['password']);
        $user->role          = 'user';
        $user->is_admin      = 0;
        $user->student_id    = $student->id;
        $user->save();

        return redirect()
            ->route('register')
            ->with('registration_success', true);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password_hash)) {
            return back()
                ->withErrors(['email' => 'Invalid credentials.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        // Clear distinction between Super Admin, Admin, and Regular User
        session([
            'user_id'       => $user->id,
            'username'      => $user->username,
            'email'         => $user->email,
            'role'          => $user->role, // Explicitly 'super_admin', 'admin', or 'user'
            'is_super_admin' => $user->role === 'super_admin',
            'is_admin'      => in_array($user->role, ['admin', 'super_admin']),
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}