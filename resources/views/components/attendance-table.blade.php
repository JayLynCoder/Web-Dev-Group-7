{{--
|--------------------------------------------------------------------------
| Attendance table — reused on the Student page and the Attendance Logs page
|--------------------------------------------------------------------------
|   <x-attendance-table :records="$logs" />                (student's own logs)
|   <x-attendance-table :records="$logs" show-student />   (admin: adds student columns)
|
| Each record is an object with: attendance_date, time_in, time_out
| (+ first_name, last_name, student_number, year_section, college_program
|    when show-student is on). Times come from Firebase as "14:05:09".
--}}
@props(['records', 'showStudent' => false, 'empty' => 'No attendance records yet.'])

@php
    use Illuminate\Support\Carbon;

    // Small helpers so the rows below stay readable
    $time = fn ($value) => $value ? Carbon::parse($value)->format('g:i A') : '—';

    $total = function ($in, $out) {
        if (! $in || ! $out) {
            return '—';
        }
        $minutes = (int) Carbon::parse($in)->diffInMinutes(Carbon::parse($out));

        return sprintf('%dh %02dm', intdiv($minutes, 60), $minutes % 60);
    };

    // complete = has time out, timed-in = today without time out, no-time-out = past day without time out
    $status = function ($record) {
        if ($record->time_out) {
            return 'complete';
        }

        return $record->attendance_date === today()->toDateString() ? 'timed-in' : 'no-time-out';
    };
@endphp

<div class="overflow-x-auto">
    <table class="w-full min-w-[560px] text-left text-sm whitespace-nowrap">
        <thead class="bg-white/5 text-[0.65rem] uppercase tracking-wider text-white/50">
            <tr>
                @if ($showStudent)
                    <th class="px-4 py-3 font-normal">Student</th>
                    <th class="px-4 py-3 font-normal">Year / Program</th>
                @endif
                <th class="px-4 py-3 font-normal">Date</th>
                <th class="px-4 py-3 font-normal">Time In</th>
                <th class="px-4 py-3 font-normal">Time Out</th>
                <th class="px-4 py-3 font-normal">Total</th>
                <th class="px-4 py-3 font-normal">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/8 text-white/80">
            @forelse ($records as $record)
                <tr>
                    @if ($showStudent)
                        <td class="px-4 py-3">
                            <span class="block text-white">{{ $record->first_name }} {{ $record->last_name }}</span>
                            <span class="text-xs text-white/50">{{ $record->student_number }}</span>
                        </td>
                        <td class="px-4 py-3">{{ $record->year_section }} · {{ $record->college_program }}</td>
                    @endif
                    <td class="px-4 py-3">{{ Carbon::parse($record->attendance_date)->format('F j, Y') }}</td>
                    <td class="px-4 py-3">{{ $time($record->time_in) }}</td>
                    <td class="px-4 py-3">{{ $time($record->time_out) }}</td>
                    <td class="px-4 py-3">{{ $total($record->time_in, $record->time_out) }}</td>
                    <td class="px-4 py-3"><x-status-badge :status="$status($record)" /></td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $showStudent ? 7 : 5 }}" class="px-4 py-8 text-center text-white/50">{{ $empty }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
