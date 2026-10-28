<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

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
            'student_number.exists' => 'No student with that student number was found. Ask an admin to register you first.',
        ]);

        $student = Student::where('student_number', $validated['student_number'])->firstOrFail();

        if (User::where('student_id', $student->id)->exists()) {
            return back()
                ->withErrors(['student_number' => 'This student number already has an account.'])
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user = new User();
        $user->username      = $validated['username'];
        $user->full_name     = $student->first_name . ' ' . $student->last_name;
        $user->email         = $validated['email'];
        $user->password_hash = password_hash($validated['password'], PASSWORD_DEFAULT);
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

        if (! $user || ! password_verify($credentials['password'], $user->password_hash)) {
            return back()
                ->withErrors(['email' => 'Invalid credentials.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        session([
            'user_id'   => $user->id,
            'is_admin'  => (bool) $user->is_admin,
            'full_name' => $user->full_name,
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