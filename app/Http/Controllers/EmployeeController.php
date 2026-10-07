<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function create()
    {
        return view('register-employee');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:80',
            'last_name'       => 'required|string|max:80',
            'employee_number' => 'required|string|max:50|unique:employees,employee_number',
            'department'      => 'required|string|max:150',
            'picture'         => 'required|image|max:5120',
        ]);

        $file = $request->file('picture');
        $filename = $validated['employee_number'] . '.' . $file->getClientOriginalExtension();
        $file->storeAs('employees', $filename, 'public');

        Employee::create([
            'first_name'      => $validated['first_name'],
            'last_name'       => $validated['last_name'],
            'employee_number' => $validated['employee_number'],
            'department'      => $validated['department'],
            'picture'         => $filename,
        ]);

        return redirect()
            ->route('register-employee')
            ->with('status', 'Employee registered successfully.');
    }
}