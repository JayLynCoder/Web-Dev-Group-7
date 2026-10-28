<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id')->get();

        // Students that don't have a user account yet
        $students = Student::whereNotIn(
            'id',
            User::whereNotNull('student_id')->pluck('student_id')
        )->orderBy('last_name')->get();

        return view('users', [
            'users'    => $users,
            'students' => $students,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username'   => 'required|string|max:100|unique:users,username',
            'email'      => 'required|email|max:255|unique:users,email',
            'password'   => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
            'student_id' => 'nullable|exists:students,id|unique:users,student_id',
            'is_admin'   => 'nullable|boolean',
        ]);

        $student = ! empty($validated['student_id'])
            ? Student::find($validated['student_id'])
            : null;

        $user = new User();
        $user->username      = $validated['username'];
        $user->full_name     = $student
            ? $student->first_name . ' ' . $student->last_name
            : $validated['username'];
        $user->email         = $validated['email'];
        $user->password_hash = password_hash($validated['password'], PASSWORD_DEFAULT);
        $user->is_admin      = $request->boolean('is_admin') ? 1 : 0;
        $user->student_id    = $validated['student_id'] ?? null;
        $user->save();

        return redirect()
            ->route('users.index')
            ->with('status', 'User account created.');
    }

    public function destroy(User $user)
    {
        if ($user->id === session('user_id')) {
            return redirect()
                ->route('users.index')
                ->withErrors(['user' => 'You cannot delete your own account.']);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('status', 'User account deleted.');
    }
}