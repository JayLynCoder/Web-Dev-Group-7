<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /** Kiosk: type or scan an employee number to time in / time out. */
    public function create(): View
    {
        return view('admin.attendance');
    }

    public function record(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            ['employeeId' => 'required|exists:employees,employee_number'],
            ['employeeId.exists' => 'No employee found with that number.'],
        );

        $employee = Employee::where('employee_number', $validated['employeeId'])->firstOrFail();

        $result = Attendance::toggleFor($employee);

        $message = match ($result['action']) {
            'in' => 'Time in recorded.',
            'out' => 'Time out recorded.',
            'done' => 'Attendance already completed for today.',
        };

        return back()
            ->with('status', $message)
            ->with('scanned_employee_id', $employee->id);
    }

    /** Logs: every attendance record, newest first, filterable by date. */
    public function logs(Request $request): View
    {
        $date = $request->date('date');

        $records = Attendance::with('employee')
            ->when($date, fn ($q) => $q->whereDate('attendance_date', $date))
            ->orderByDesc('attendance_date')
            ->orderByDesc('time_in')
            ->paginate(15)
            ->withQueryString();

        return view('admin.logs', compact('records', 'date'));
    }
}
