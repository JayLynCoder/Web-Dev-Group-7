<?php

namespace App\Http\Controllers;

use App\Services\UserStore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;

class AttendanceController extends Controller
{
    // Minimum minutes between time in and time out
    private const MIN_MINUTES_BEFORE_TIME_OUT = 10;

    public function __construct(
        protected Database $database,
        protected UserStore $users
    ) {
    }

    // Admin: attendance login page
    public function create()
    {
        return view('attendance');
    }

    // Admin: enter student number
    public function recordAttendance(Request $request)
    {
        $validated = $request->validate([
            'studentId' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9\-_]+$/'],
        ]);

        $student = $this->findStudent($validated['studentId']);

        if (! $student) {
            return back()
                ->withErrors(['studentId' => 'Student number not found.'])
                ->withInput();
        }

        $result = $this->toggleAttendance($student);

        if (! $result['ok']) {
            return back()
                ->withErrors(['studentId' => $result['message']])
                ->with('scanned_student', $student);
        }

        return back()
            ->with('status', $result['message'])
            ->with('scanned_student', $student);
    }

    // Admin: all attendance logs, optional date filter
    public function logs(Request $request)
    {
        $date = $request->input('date');

        $students   = $this->database->getReference('students')->getValue() ?? [];
        $attendance = $this->database->getReference('attendance')->getValue() ?? [];

        $logs = collect();

        foreach ($attendance as $studentNumber => $days) {
            $student = $students[$studentNumber] ?? null;

            if (! $student || ! is_array($days)) {
                continue;
            }

            foreach ($days as $day => $record) {
                if ($date && $day !== $date) {
                    continue;
                }

                $logs->push((object) [
                    'attendance_date' => $day,
                    'time_in'         => $record['time_in'] ?? null,
                    'time_out'        => $record['time_out'] ?? null,
                    'first_name'      => $student['first_name'] ?? '',
                    'last_name'       => $student['last_name'] ?? '',
                    'student_number'  => $studentNumber,
                    'year_section'    => $student['year_section'] ?? '',
                    'college_program' => $student['college_program'] ?? '',
                ]);
            }
        }

        $logs = $logs
            ->sortByDesc(fn ($log) => $log->attendance_date . ' ' . ($log->time_in ?? ''))
            ->values()
            ->take(500);

        return view('attendance-logs', [
            'logs' => $logs,
            'date' => $date,
        ]);
    }

    // Logged-in student account: own logs + record button
    public function studentAttendance()
    {
        $student = $this->currentStudent();

        $logs = collect();
        $today = null;

        if ($student) {
            $days = $this->database
                ->getReference("attendance/{$student->student_number}")
                ->getValue() ?? [];

            krsort($days);

            foreach ($days as $day => $record) {
                $logs->push((object) [
                    'student_id'      => $student->student_number,
                    'attendance_date' => $day,
                    'time_in'         => $record['time_in'] ?? null,
                    'time_out'        => $record['time_out'] ?? null,
                ]);
            }

            $todayKey = now()->toDateString();

            if (isset($days[$todayKey])) {
                $today = (object) [
                    'student_id'      => $student->student_number,
                    'attendance_date' => $todayKey,
                    'time_in'         => $days[$todayKey]['time_in'] ?? null,
                    'time_out'        => $days[$todayKey]['time_out'] ?? null,
                ];
            }
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
        $student = $this->currentStudent();

        if (! $student) {
            return redirect()
                ->route('student-attendance')
                ->withErrors(['student' => 'Your account is not linked to a student record yet.']);
        }

        $result = $this->toggleAttendance($student);

        if (! $result['ok']) {
            return redirect()
                ->route('student-attendance')
                ->withErrors(['student' => $result['message']]);
        }

        return redirect()
            ->route('student-attendance')
            ->with('status', $result['message']);
    }

    // The student linked to the logged-in account (or null)
    private function currentStudent(): ?object
    {
        $user = $this->users->find((string) session('user_id'));

        if (! $user) {
            abort(404);
        }

        return $user->student_id ? $this->findStudent((string) $user->student_id) : null;
    }

    // Look up one student in Firebase (returns an object, or null if not found)
    private function findStudent(string $studentNumber): ?object
    {
        if (! preg_match('/^[A-Za-z0-9\-_]+$/', $studentNumber)) {
            return null;
        }

        $data = $this->database->getReference("students/{$studentNumber}")->getValue();

        if (! $data) {
            return null;
        }

        return (object) ($data + ['id' => $studentNumber]);
    }

    // Shared logic: time in, then time out (10+ minutes later), then completed
    private function toggleAttendance(object $student): array
    {
        $today = now()->toDateString();
        $ref = $this->database->getReference("attendance/{$student->student_number}/{$today}");
        $record = $ref->getValue();

        // First scan of the day: time in
        if (! $record) {
            $ref->set(['time_in' => now()->toTimeString()]);
            return ['ok' => true, 'message' => 'Time in recorded.'];
        }

        // Already timed out
        if (! empty($record['time_out'])) {
            return ['ok' => true, 'message' => 'Attendance already completed for today.'];
        }

        // Timed in, but not yet allowed to time out
        $timeIn = Carbon::parse($today . ' ' . $record['time_in']);
        $earliestTimeOut = $timeIn->copy()->addMinutes(self::MIN_MINUTES_BEFORE_TIME_OUT);

        if (now()->lt($earliestTimeOut)) {
            $secondsLeft = now()->diffInSeconds($earliestTimeOut);
            $minutesLeft = (int) ceil($secondsLeft / 60);

            return [
                'ok'      => false,
                'message' => 'You timed in at ' . $timeIn->format('g:i A') . '. Please wait '
                    . $minutesLeft . ' more minute' . ($minutesLeft === 1 ? '' : 's')
                    . ' before timing out.',
            ];
        }

        $ref->update(['time_out' => now()->toTimeString()]);
        return ['ok' => true, 'message' => 'Time out recorded.'];
    }
}