<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Attendance::with('employee')
            ->whereDate('attendance_date', today())
            ->orderByDesc('time_in')
            ->get();

        return view('admin.dashboard', [
            'stats' => [
                'employees' => Employee::count(),
                'present' => $today->count(),
                'onDuty' => $today->whereNull('time_out')->count(),
                'late' => $today->filter->is_late->count(),
            ],
            'today' => $today,
            'members' => config('members'),
        ]);
    }
}
