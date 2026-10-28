<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    // Admin: attendance login page
    public function create()
    {
        return view('attendance');
    }

    // Admin: enter student number
    public function recordAttendance(Request $request)
    {
        $validated = $request->validate([
            'studentId' => 'required|exists:students,student_number',
        ]);

        $student = Student::where('student_number', $validated['studentId'])->firstOrFail();

        return back()
            ->with('status', $this->toggleAttendance($student))
            ->with('scanned_student', $student);
    }

    // Admin: all attendance logs, optional date filter
    public function logs(Request $request)
    {
        $query = DB::table('attendance')
            ->join('students', 'students.id', '=', 'attendance.student_id')
            ->select(
                'attendance.attendance_date',
                'attendance.time_in',
                'attendance.time_out',
                'students.first_name',
                'students.last_name',
                'students.student_number',
                'students.year_section',
                'students.college_program'
            )
            ->orderByDesc('attendance.attendance_date')
            ->orderByDesc('attendance.time_in');

        if ($request->filled('date')) {
            $query->where('attendance.attendance_date', $request->input('date'));
        }

        return view('attendance-logs', [
            'logs' => $query->limit(500)->get(),
            'date' => $request->input('date'),
        ]);
    }

    // Logged-in student account: own logs + record button
    public function studentAttendance()
    {
        $user = User::findOrFail(session('user_id'));
        $student = $user->student_id ? Student::find($user->student_id) : null;

        $logs = collect();
        $today = null;

        if ($student) {
            $logs = Attendance::where('student_id', $student->id)
                ->orderByDesc('attendance_date')
                ->get();

            $today = Attendance::where('student_id', $student->id)
                ->where('attendance_date', now()->toDateString())
                ->first();
        }

        return view('student-attendance', [
            'student' => $student,
            'logs'    => $logs,
            'today'   => $today,
        ]);
    }

    // Logged-in student account: record their own attendance
    public function recordOwnAttendance()
    {
        $user = User::findOrFail(session('user_id'));
        $student = $user->student_id ? Student::find($user->student_id) : null;

        if (! $student) {
            return redirect()
                ->route('student-attendance')
                ->withErrors(['student' => 'Your account is not linked to a student record yet.']);
        }

        return redirect()
            ->route('student-attendance')
            ->with('status', $this->toggleAttendance($student));
    }

    // Shared logic: time in, then time out, then completed
    private function toggleAttendance(Student $student): string
    {
        $attendance = Attendance::where('student_id', $student->id)
            ->where('attendance_date', now()->toDateString())
            ->first();

        if (! $attendance) {
            Attendance::create([
                'student_id'      => $student->id,
                'attendance_date' => now()->toDateString(),
                'time_in'         => now()->toTimeString(),
            ]);
            return 'Time in recorded.';
        }

        if (! $attendance->time_out) {
            $attendance->update(['time_out' => now()->toTimeString()]);
            return 'Time out recorded.';
        }

        return 'Attendance already completed for today.';
    }
}