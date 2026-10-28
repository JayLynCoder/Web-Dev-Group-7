<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function dashboard(): View
    {
        $employee = $this->employee();

        return view('employee.dashboard', [
            'employee' => $employee,
            'today' => $employee?->todayAttendance,
            'recent' => $employee?->attendance()->orderByDesc('attendance_date')->limit(5)->get() ?? collect(),
        ]);
    }

    public function attendance(): View
    {
        $employee = $this->employee();

        return view('employee.attendance', [
            'employee' => $employee,
            'records' => $employee?->attendance()->orderByDesc('attendance_date')->paginate(15),
        ]);
    }

    public function profile(): View
    {
        $employee = $this->employee();

        return view('employee.profile', [
            'employee' => $employee,
            'user' => \App\Models\User::current(),
            'daysPresent' => $employee?->attendance()->count() ?? 0,
            'daysLate' => $employee?->attendance()->get()->filter->is_late->count() ?? 0,
        ]);
    }

    /** Clock In / Clock Out button on the dashboard. */
    public function clock(): RedirectResponse
    {
        $employee = $this->employee();

        abort_unless($employee, 403, 'Your account is not linked to an employee record.');

        $result = Attendance::toggleFor($employee);

        return redirect()
            ->route('employee.dashboard')
            ->with('clock', [
                'action' => $result['action'],
                'time' => $result['time']->format('g:i A'),
            ]);
    }

    /** The employee record linked to the logged-in user (null if not linked yet). */
    private function employee(): ?Employee
    {
        return Employee::where('user_id', session('user_id'))->first();
    }
}
