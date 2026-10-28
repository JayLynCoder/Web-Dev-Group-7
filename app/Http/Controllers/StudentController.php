<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function create()
    {
        return view('register-student');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:80',
            'last_name'      => 'required|string|max:80',
            'student_number' => [
                'required', 'string', 'max:50',
                'regex:/^[A-Za-z0-9\-_]+$/',
                'unique:students,student_number',
            ],
            'year_section'    => ['required', 'string', 'max:50', 'regex:/^[1-9]-[0-9]{1,2}$/'],
            'college_program' => 'required|string|max:150',
            'picture'         => 'required|file|mimes:jpeg,jpg|max:5120',
        ], [
            'student_number.regex' => 'Student number may only contain letters, numbers, dashes and underscores.',
            'year_section.regex'   => 'Year / Section must be in the format 3-1.',
            'picture.mimes'        => 'The picture must be a JPEG file.',
        ]);

        // Saved as "<student number>.jpg"
        $filename = $validated['student_number'] . '.jpg';
        $request->file('picture')->storeAs('students', $filename, 'public');

        Student::create([
            'first_name'      => $validated['first_name'],
            'last_name'       => $validated['last_name'],
            'student_number'  => $validated['student_number'],
            'year_section'    => $validated['year_section'],
            'college_program' => $validated['college_program'],
            'picture'         => $filename,
        ]);

        return redirect()
            ->route('register-student')
            ->with('status', 'Student registered successfully.');
    }
}