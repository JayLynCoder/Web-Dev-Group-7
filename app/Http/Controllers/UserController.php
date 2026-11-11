<?php

namespace App\Http\Controllers;

use App\Services\UserStore;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Kreait\Firebase\Contract\Database;

class UserController extends Controller
{
    public function __construct(
        protected Database $database,
        protected UserStore $users
    ) {
    }

    // Only the super admin may manage user accounts
    private function requireSuperAdmin(): void
    {
        abort_unless(
            session('role') === 'superadmin',
            403,
            'Only the super admin can manage user accounts.'
        );
    }

    // Students (from Firebase) that don't have a user account yet,
    // plus the student linked to $currentStudentId (if editing)
    private function availableStudents($users, ?string $currentStudentId = null)
    {
        $taken = collect($users)
            ->pluck('student_id')
            ->filter()
            ->map(fn ($value) => (string) $value)
            ->reject(fn ($value) => $value === (string) $currentStudentId)
            ->all();

        $allStudents = $this->database->getReference('students')->getValue() ?? [];

        return collect($allStudents)
            ->map(function ($student, $studentNumber) {
                return (object) ($student + [
                    'id'             => (string) $studentNumber,
                    'student_number' => (string) $studentNumber,
                ]);
            })
            ->reject(fn ($student) => in_array((string) $student->student_number, $taken, true))
            ->sortBy('last_name')
            ->values();
    }

    public function index()
    {
        $this->requireSuperAdmin();

        $users = collect($this->users->all());

        return view('users', [
            'users'    => $users,
            'students' => $this->availableStudents($users),
        ]);
    }

    public function store(Request $request)
    {
        $this->requireSuperAdmin();

        $validated = $request->validate([
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
            'student_id' => [
                'bail', 'nullable', 'string', 'max:50',
                'regex:/^[A-Za-z0-9\-_]+$/',
                function ($attribute, $value, $fail) {
                    $exists = $this->database
                        ->getReference("students/{$value}")
                        ->getSnapshot()
                        ->exists();

                    if (! $exists) {
                        $fail('The selected student does not exist.');
                    } elseif ($this->users->studentLinked($value)) {
                        $fail('This student already has an account.');
                    }
                },
            ],
            'is_admin' => 'nullable|boolean',
        ]);

        $student = ! empty($validated['student_id'])
            ? $this->database->getReference("students/{$validated['student_id']}")->getValue()
            : null;

        $this->users->create([
            'username'      => $validated['username'],
            'full_name'     => $student
                ? $student['first_name'] . ' ' . $student['last_name']
                : $validated['username'],
            'email'         => $validated['email'],
            'password_hash' => password_hash($validated['password'], PASSWORD_DEFAULT),
            'role'          => $request->boolean('is_admin') ? 'admin' : 'student',
            'student_id'    => $validated['student_id'] ?? '',
        ]);

        return redirect()
            ->route('users.index')
            ->with('status', 'User account created.');
    }

    public function edit(string $user)
    {
        $this->requireSuperAdmin();

        $target = $this->users->find($user);

        abort_unless($target, 404);

        $students = $this->availableStudents(
            collect($this->users->all()),
            $target->student_id ? (string) $target->student_id : null
        );

        return view('users-edit', [
            'user'     => $target,
            'students' => $students,
        ]);
    }

    public function update(Request $request, string $user)
    {
        $this->requireSuperAdmin();

        $target = $this->users->find($user);

        abort_unless($target, 404);

        $isSuperAdmin = $target->role === 'superadmin';

        $validated = $request->validate([
            'username' => [
                'required', 'string', 'max:100',
                function ($attribute, $value, $fail) use ($user) {
                    if ($this->users->usernameExists($value, $user)) {
                        $fail('The username has already been taken.');
                    }
                },
            ],
            'email' => [
                'required', 'email', 'max:255',
                function ($attribute, $value, $fail) use ($user) {
                    if ($this->users->emailExists($value, $user)) {
                        $fail('The email has already been taken.');
                    }
                },
            ],
            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
            'role' => $isSuperAdmin ? 'nullable' : 'required|in:admin,student',
            'student_id' => [
                'bail', 'nullable', 'string', 'max:50',
                'regex:/^[A-Za-z0-9\-_]+$/',
                function ($attribute, $value, $fail) use ($user) {
                    $exists = $this->database
                        ->getReference("students/{$value}")
                        ->getSnapshot()
                        ->exists();

                    if (! $exists) {
                        $fail('The selected student does not exist.');
                    } elseif ($this->users->studentLinked($value, $user)) {
                        $fail('This student already has an account.');
                    }
                },
            ],
        ]);

        $student = ! empty($validated['student_id'])
            ? $this->database->getReference("students/{$validated['student_id']}")->getValue()
            : null;

        $fullName = $student
            ? $student['first_name'] . ' ' . $student['last_name']
            : $validated['username'];

        $data = [
            'username'   => $validated['username'],
            'full_name'  => $fullName,
            'email'      => $validated['email'],
            // The super admin's role can't be changed from this page
            'role'       => $isSuperAdmin ? 'superadmin' : $validated['role'],
            'student_id' => $validated['student_id'] ?? '',
        ];

        if (! empty($validated['password'])) {
            $data['password_hash'] = password_hash($validated['password'], PASSWORD_DEFAULT);
        }

        $this->users->update($user, $data);

        // Keep the session name fresh if the super admin edited their own account
        if ($user === (string) session('user_id')) {
            session(['full_name' => $fullName]);
        }

        return redirect()
            ->route('users.index')
            ->with('status', 'User account updated.');
    }

    public function destroy(string $user)
    {
        $this->requireSuperAdmin();

        if ($user === (string) session('user_id')) {
            return redirect()
                ->route('users.index')
                ->withErrors(['user' => 'You cannot delete your own account.']);
        }

        $target = $this->users->find($user);

        if ($target && $target->role === 'superadmin') {
            return redirect()
                ->route('users.index')
                ->withErrors(['user' => 'The super admin account cannot be deleted.']);
        }

        if ($target) {
            $this->users->delete($user);
        }

        return redirect()
            ->route('users.index')
            ->with('status', 'User account deleted.');
    }
}