<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function create()
    {
        return view('attendance');
    }

    public function recordAttendance(Request $request)
    {
        $validated = $request->validate([
            'employeeId' => 'required|exists:employees,employee_number',
        ]);

        $employee = Employee::where('employee_number', $validated['employeeId'])->firstOrFail();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('attendance_date', now()->toDateString())
            ->first();

        if (! $attendance) {
            Attendance::create([
                'employee_id'     => $employee->id,
                'attendance_date' => now()->toDateString(),
                'time_in'         => now()->toTimeString(),
            ]);
            $message = 'Time in recorded.';
        } elseif (! $attendance->time_out) {
            $attendance->update(['time_out' => now()->toTimeString()]);
            $message = 'Time out recorded.';
        } else {
            $message = 'Attendance already completed for today.';
        }

        return back()
            ->with('status', $message)
            ->with('scanned_employee', $employee);
    }
}