<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function create()
    {
        return view('attendance');
    }

    public function recordAttendance(Request $request)
    {
        $validated = $request->validate([
            'studentId' => 'required|exists:students,student_number',
        ]);

        $student = Student::where('student_number', $validated['studentId'])->firstOrFail();

        $result = $this->toggleAttendance($student);

        return back()
            ->with(str_contains($result, 'Error') ? 'error' : 'status', $result)
            ->with('scanned_student', $student);
    }

    public function logs(Request $request)
    {
        $query = DB::table('attendance')
            ->join('students', 'students.id', '=', 'attendance.student_id')
            ->select(
                'attendance.attendance_date',
                'attendance.time_in',
                'attendance.time_out',
                'students.student_number',
                'students.first_name',
                'students.last_name',
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

    public function studentAttendance()
    {
        $user = User::findOrFail(session('user_id'));
        
        // Resolve student record (with auto-linking fallback by student number)
        $student = $user->student_id ? Student::find($user->student_id) : null;

        if (! $student) {
            $student = Student::where('student_number', $user->username)->first();
            if ($student) {
                $user->student_id = $student->id;
                $user->save();
            }
        }

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

    public function recordOwnAttendance()
    {
        $user = User::findOrFail(session('user_id'));
        $student = $user->student_id ? Student::find($user->student_id) : null;

        if (! $student) {
            $student = Student::where('student_number', $user->username)->first();
            if ($student) {
                $user->student_id = $student->id;
                $user->save();
            }
        }

        if (! $student) {
            return redirect()
                ->route('student-attendance')
                ->withErrors(['student' => 'Your account is not linked to a student record yet.']);
        }

        $result = $this->toggleAttendance($student);

        return redirect()
            ->route('student-attendance')
            ->with(str_contains($result, 'Error') ? 'error' : 'status', $result);
    }

    public function updateStudentProfile(Request $request)
    {
        $user = User::findOrFail(session('user_id'));
        $student = $user->student_id ? Student::find($user->student_id) : null;

        if (! $student) {
            $student = Student::where('student_number', $user->username)->first();
            if ($student) {
                $user->student_id = $student->id;
                $user->save();
            }
        }

        if (! $student) {
            return back()->withErrors(['error' => 'No student profile linked to your account.']);
        }

        $validated = $request->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'year_section'    => 'required|string|max:50',
            'college_program' => 'required|string|max:100',
        ]);

        $student->update($validated);

        return redirect()->route('student-attendance')->with('status', 'Profile updated successfully.');
    }

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
            return 'Time in recorded successfully.';
        }

        if (! $attendance->time_out) {
            $timeIn = Carbon::parse($attendance->attendance_date . ' ' . $attendance->time_in);
            $diffInMinutes = $timeIn->diffInMinutes(now());

            if ($diffInMinutes < 15) {
                $remaining = 15 - $diffInMinutes;
                return "Error: You must wait at least 15 minutes between check-in and check-out. ({$remaining} minutes remaining)";
            }

            $attendance->update(['time_out' => now()->toTimeString()]);
            return 'Time out recorded successfully.';
        }

        return 'Attendance already completed for today.';
    }
}