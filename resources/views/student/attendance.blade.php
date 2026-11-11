{{--
|--------------------------------------------------------------------------
| Student: My Attendance  (AttendanceController@studentAttendance)
|--------------------------------------------------------------------------
| Variables from the controller:
|   $student  the student linked to this account (null if not linked yet)
|   $today    today's record {time_in, time_out} or null
|   $logs     all of this student's records, newest first
|
| The Time In / Time Out button opens a confirm modal; "Confirm" submits
| #attendance-form → POST /student-attendance/record → back to this page with
| session('status') (success) or an error, which the result modal shows.
--}}
@php
    use Illuminate\Support\Carbon;

    // Today's state: not-timed-in → timed-in → complete
    $state = match (true) {
        ! $today => 'not-timed-in',
        ! $today->time_out => 'timed-in',
        default => 'complete',
    };

    $isTimeIn = $state === 'not-timed-in';

    $statusLabel = [
        'not-timed-in' => 'Not Timed In',
        'timed-in' => 'Timed In',
        'complete' => 'Done for Today',
    ][$state];

    $dotColor = [
        'not-timed-in' => 'bg-white/40',
        'timed-in' => 'bg-hexa-green shadow-[0_0_8px_rgba(101,201,140,0.8)]',
        'complete' => 'bg-hexa-cyan',
    ][$state];

    $format = fn ($time) => $time ? Carbon::parse($time)->format('g:i A') : '—';

    // The controller only allows time out 10 minutes after time in
    $earliestTimeOut = $state === 'timed-in' ? Carbon::parse($today->time_in)->addMinutes(10) : null;

    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');

    $daysAttended = $logs->count();
    $daysComplete = $logs->whereNotNull('time_out')->count();

    // Result of the last button press (set by the controller after redirecting back)
    $resultError = $errors->first('student');
    $resultStatus = session('status');
@endphp

<x-layouts.portal title="My Attendance" :heading="'My Attendance'" :on-duty="$state === 'timed-in'">
    @unless ($student)
        {{-- ============ ACCOUNT NOT LINKED ============ --}}
        <x-card class="mx-auto max-w-xl text-center">
            <div class="mx-auto mb-4 flex size-14 items-center justify-center rounded-xl border border-hexa-amber/30 bg-hexa-amber/10 text-2xl text-hexa-amber">!</div>
            <h2 class="mb-2 text-lg font-bold">Account not linked yet</h2>
            <p class="text-sm text-white/60">Your account isn't connected to a student record. Please ask an admin to link it.</p>
        </x-card>
    @else
        {{-- ============ WELCOME ============ --}}
        <section class="mb-6">
            <p class="eyebrow mb-2">Today's Attendance</p>
            <h2 class="text-2xl font-bold sm:text-3xl">{{ $greeting }}, {{ $student->first_name }}.</h2>
            <p class="mt-1 text-sm text-white/65">Record your time in and time out for today.</p>
        </section>

        {{-- ============ STUDENT INFO + STATUS ============ --}}
        <x-card class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <x-avatar :student="$student" />
                <div>
                    <h3 class="font-bold">{{ $student->first_name }} {{ $student->last_name }}</h3>
                    <p class="text-xs text-white/55">Student No. {{ $student->student_number }}</p>
                    <p class="text-xs text-white/55">{{ $student->year_section }} · {{ $student->college_program }}</p>
                </div>
            </div>
            <div class="sm:text-right">
                <span class="mb-1 block text-[0.65rem] uppercase tracking-wider text-white/50">Current Status</span>
                <span class="flex items-center gap-2 text-sm font-bold sm:justify-end">
                    <span class="size-2 rounded-full {{ $dotColor }}"></span>{{ $statusLabel }}
                </span>
            </div>
        </x-card>

        {{-- ============ TIME IN / OUT + SUMMARY ============ --}}
        <div class="mb-5 grid gap-5 lg:grid-cols-[minmax(0,1.5fr)_minmax(280px,0.8fr)]">

            {{-- Left: live clock + the big button --}}
            <x-card class="flex min-h-[400px] flex-col items-center justify-center text-center">
                <p class="eyebrow mb-3">Attendance</p>
                <h2 class="text-lg font-bold">Today's Session</h2>

                <div class="my-8">
                    <span class="mb-2 block text-[0.65rem] text-white/50">CURRENT TIME</span>
                    {{-- data-live-clock / data-live-date are updated every second by resources/js/portal.js --}}
                    <strong data-live-clock class="block text-[clamp(2rem,5vw,3.3rem)] font-bold tracking-wide [text-shadow:0_0_15px_rgba(104,212,255,0.15)]">{{ now()->format('h:i:s A') }}</strong>
                    <span data-live-date class="mt-2 block text-xs text-white/55">{{ now()->format('F j, Y') }}</span>
                </div>

                <div class="mb-6 grid w-full max-w-[420px] grid-cols-[1fr_1px_1fr] items-center border-y border-white/12 py-4">
                    <div>
                        <span class="mb-1 block text-[0.65rem] uppercase text-white/50">Time In</span>
                        <strong class="text-sm">{{ $format($today?->time_in) }}</strong>
                    </div>
                    <div class="h-8 bg-white/15"></div>
                    <div>
                        <span class="mb-1 block text-[0.65rem] uppercase text-white/50">Time Out</span>
                        <strong class="text-sm">{{ $format($today?->time_out) }}</strong>
                    </div>
                </div>

                {{-- The real form (empty). The "Confirm" button inside the modal submits it via form="attendance-form". --}}
                <form id="attendance-form" method="POST" action="{{ route('student-attendance.record') }}">@csrf</form>

                <button type="button" class="btn-primary w-full max-w-[420px]" data-modal-open="confirm-attendance" @disabled($state === 'complete')>
                    {{ ['not-timed-in' => 'Time In', 'timed-in' => 'Time Out', 'complete' => 'Attendance Complete'][$state] }}
                </button>

                <p class="mt-3 text-xs text-white/45">
                    @if ($state === 'not-timed-in')
                        Start your session for today.
                    @elseif ($state === 'timed-in')
                        You can time out from {{ $earliestTimeOut->format('g:i A') }}.
                    @else
                        Your attendance for today is complete.
                    @endif
                </p>
            </x-card>

            {{-- Right: student details + counts --}}
            <x-card eyebrow="Profile" title="Student Information">
                <dl class="text-xs">
                    <div class="flex justify-between gap-4 border-t border-white/10 py-3 first:border-t-0"><dt class="text-white/55">Student No.</dt><dd class="font-bold">{{ $student->student_number }}</dd></div>
                    <div class="flex justify-between gap-4 border-t border-white/10 py-3"><dt class="text-white/55">Year / Section</dt><dd class="font-bold">{{ $student->year_section }}</dd></div>
                    <div class="flex justify-between gap-4 border-t border-white/10 py-3"><dt class="text-white/55">Program</dt><dd class="font-bold">{{ $student->college_program }}</dd></div>
                </dl>

                <div class="mt-4 grid grid-cols-2 gap-3 text-center">
                    <div class="rounded-lg border border-white/10 bg-white/5 p-3">
                        <p class="text-2xl font-bold text-hexa-cyan">{{ $daysAttended }}</p>
                        <p class="text-[0.6rem] uppercase text-white/50">Days logged</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/5 p-3">
                        <p class="text-2xl font-bold text-hexa-green">{{ $daysComplete }}</p>
                        <p class="text-[0.6rem] uppercase text-white/50">Complete</p>
                    </div>
                </div>
            </x-card>
        </div>

        {{-- ============ HISTORY ============ --}}
        <x-card eyebrow="Activity" title="Attendance History">
            <x-attendance-table :records="$logs" />
        </x-card>

        {{-- ============ CONFIRM MODAL ============ --}}
        <x-modal id="confirm-attendance">
            <div class="mb-4 flex size-13 items-center justify-center rounded-lg border border-hexa-cyan/30 bg-hexa-cyan/8 text-xl text-hexa-cyan">◷</div>
            <h2 class="mb-2 text-lg font-bold">Confirm {{ $isTimeIn ? 'Time In' : 'Time Out' }}</h2>
            <p class="mb-5 text-sm leading-relaxed text-white/60">
                Are you sure you want to {{ $isTimeIn ? 'time in and start' : 'time out and end' }} your session?
            </p>

            <dl class="mb-5 rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-xs">
                <div class="flex justify-between py-2"><dt class="text-white/45">Student</dt><dd class="font-bold">{{ $student->first_name }} {{ $student->last_name }}</dd></div>
                <div class="flex justify-between py-2"><dt class="text-white/45">Date</dt><dd class="font-bold" data-live-date>{{ now()->format('F j, Y') }}</dd></div>
                <div class="flex justify-between py-2"><dt class="text-white/45">Time</dt><dd class="font-bold" data-live-clock="short">{{ now()->format('h:i A') }}</dd></div>
            </dl>

            <div class="grid gap-2 sm:grid-cols-2">
                <button type="button" class="btn-ghost" data-modal-close>Cancel</button>
                <button type="submit" form="attendance-form" class="btn-primary">Confirm {{ $isTimeIn ? 'Time In' : 'Time Out' }}</button>
            </div>
        </x-modal>

        {{-- ============ RESULT MODAL (shown after the form posts back) ============ --}}
        @if ($resultStatus || $resultError)
            <x-modal id="attendance-result" data-auto-open :data-auto-close="$resultError ? null : 3000">
                <div class="text-center">
                    @if ($resultError)
                        <div class="mx-auto mb-4 flex size-16 items-center justify-center rounded-full border border-hexa-amber/35 bg-hexa-amber/10 text-3xl text-hexa-amber">!</div>
                        <h2 class="mb-2 text-lg font-bold">Not Yet</h2>
                        <p class="mb-5 text-sm text-white/60">{{ $resultError }}</p>
                        <button type="button" class="btn-primary w-full" data-modal-close>OK</button>
                    @else
                        <div class="mx-auto mb-4 flex size-16 items-center justify-center rounded-full border border-hexa-green/35 bg-hexa-green/10 text-3xl text-hexa-green">✓</div>
                        <h2 class="mb-2 text-lg font-bold">{{ $resultStatus }}</h2>
                        <strong class="mb-5 block text-2xl text-hexa-cyan">{{ $format($today?->time_out ?? $today?->time_in) }}</strong>
                        <div class="animate-shrink h-0.5 w-full bg-hexa-cyan"></div>
                    @endif
                </div>
            </x-modal>
        @endif
    @endunless
</x-layouts.portal>
