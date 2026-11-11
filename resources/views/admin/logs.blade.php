{{--
|--------------------------------------------------------------------------
| Admin: Attendance Logs
|--------------------------------------------------------------------------
| From AttendanceController@logs:
|   $logs  collection of records (newest first, max 500)
|   $date  the date filter (string "2026-11-12") or null
--}}
<x-layouts.portal title="Attendance Logs">
    <x-card eyebrow="Records" title="All Student Attendance">
        <x-slot:action>
            {{-- GET form: the filter ends up in the URL, e.g. /attendance/logs?date=2026-11-12 --}}
            <form method="GET" action="{{ route('attendance.logs') }}" class="flex flex-wrap items-center gap-2">
                <label for="date" class="sr-only">Filter by date</label>
                <input type="date" name="date" id="date" value="{{ $date }}" class="field h-9 w-auto text-xs">
                <button type="submit" class="btn-ghost min-h-9 text-xs">Filter</button>
                @if ($date)
                    <a href="{{ route('attendance.logs') }}" class="text-xs text-hexa-cyan hover:text-hexa-cyan-light">Clear</a>
                @endif
            </form>
        </x-slot:action>

        <p class="mb-4 text-xs text-white/50">
            {{ $logs->count() }} {{ Str::plural('record', $logs->count()) }}
            @if ($date) on {{ \Illuminate\Support\Carbon::parse($date)->format('F j, Y') }} @endif
        </p>

        <x-attendance-table :records="$logs" show-student empty="No attendance records found." />
    </x-card>
</x-layouts.portal>
