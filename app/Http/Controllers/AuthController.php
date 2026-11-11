<?php

namespace App\Http\Controllers;

use App\Services\UserStore;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Kreait\Firebase\Contract\Database;

class AuthController extends Controller
{
    public function __construct(
        protected Database $database,
        protected UserStore $users
    ) {
    }

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
            'student_number' => [
                'bail', 'required', 'string', 'max:50',
                'regex:/^[A-Za-z0-9\-_]+$/',
                function ($attribute, $value, $fail) {
                    $exists = $this->database
                        ->getReference("students/{$value}")
                        ->getSnapshot()
                        ->exists();

                    if (! $exists) {
                        $fail('No student with that student number was found. Ask an admin to register you first.');
                    }
                },
            ],
            'username' => [
                'required', 'string', 'max:100',
                function ($attribute, $value, $fail) {
                    if ($this->users->usernameExists($value)) {
                        $fail('The username has already been taken.');
                    }
                },
            ],
            'email' => [
                'required', 'email', 'max:255',
                function ($attribute, $value, $fail) {
                    if ($this->users->emailExists($value)) {
                        $fail('The email has already been taken.');
                    }
                },
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ], [
            'student_number.regex' => 'Student number may only contain letters, numbers, dashes and underscores.',
        ]);

        if ($this->users->studentLinked($validated['student_number'])) {
            return back()
                ->withErrors(['student_number' => 'This student number already has an account.'])
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $student = $this->database
            ->getReference("students/{$validated['student_number']}")
            ->getValue();

        $this->users->create([
            'username'      => $validated['username'],
            'full_name'     => $student['first_name'] . ' ' . $student['last_name'],
            'email'         => $validated['email'],
            'password_hash' => password_hash($validated['password'], PASSWORD_DEFAULT),
            'role'          => 'student',
            'student_id'    => $validated['student_number'],
        ]);

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

        $user = $this->users->findByEmail($credentials['email']);

        if (! $user || ! password_verify($credentials['password'], $user->password_hash)) {
            return back()
                ->withErrors(['email' => 'Invalid credentials.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        session([
            'user_id'   => $user->id,
            'is_admin'  => (bool) $user->is_admin,
            'role'      => $user->role,
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