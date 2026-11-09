<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Show the "Register Student" form inside the admin dashboard
    public function create()
    {
        return view('register-student');
    }

    // Whitelist / store the student number
    public function store(Request $request)
    {
        $request->validate([
            'student_number' => 'required|string|max:50|unique:students,student_number',
        ]);

        Student::create([
            'student_number' => $request->student_number,
        ]);

        return redirect()->route('register-student')->with('status', 'Student number registered successfully.');
    }
}