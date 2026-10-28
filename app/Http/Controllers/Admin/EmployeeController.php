<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(): View
    {
        $employees = Employee::with('user')->orderBy('last_name')->get();

        return view('admin.employees', compact('employees'));
    }

    public function create(): View
    {
        return view('admin.register-employee');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'employee_number' => 'required|string|max:50|unique:employees,employee_number',
            'department' => 'required|string|max:150',
            'picture' => 'required|image|max:5120',
            // Optional: give the employee a login for the Employee Portal.
            'email' => 'nullable|email|max:255|unique:users,email',
            'password' => 'nullable|required_with:email|string|min:8',
        ]);

        $file = $request->file('picture');
        $filename = $validated['employee_number'] . '.' . $file->getClientOriginalExtension();
        $file->storeAs('employees', $filename, 'public');

        DB::transaction(function () use ($validated, $filename) {
            $user = null;

            if (! empty($validated['email'])) {
                $user = User::create([
                    'username' => $validated['employee_number'],
                    'email' => $validated['email'],
                    'full_name' => $validated['first_name'] . ' ' . $validated['last_name'],
                    'password_hash' => password_hash($validated['password'], PASSWORD_BCRYPT),
                    'is_admin' => false,
                ]);
            }

            Employee::create([
                'user_id' => $user?->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'employee_number' => $validated['employee_number'],
                'department' => $validated['department'],
                'picture' => $filename,
            ]);
        });

        return redirect()
            ->route('admin.employees.create')
            ->with('status', 'Employee registered successfully.');
    }
}
