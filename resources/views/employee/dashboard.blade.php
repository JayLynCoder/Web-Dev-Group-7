@php
    // Today's state: not-clocked-in → on-duty → complete
    $state = match (true) {
        ! $today => 'not-clocked-in',
        ! $today->time_out => 'on-duty',
        default => 'complete',
    };
    $statusLabel = ['not-clocked-in' => 'Not Clocked In', 'on-duty' => 'On Duty', 'complete' => 'Workday Complete'][$state];
    $dotColor = ['not-clocked-in' => 'bg-[#8b8b8b]', 'on-duty' => 'bg-hexa-green shadow-[0_0_8px_rgba(46,157,97,0.7)]', 'complete' => 'bg-hexa-cyan'][$state];
    $isClockIn = $state === 'not-clocked-in';
    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
    $start = \Illuminate\Support\Carbon::parse(config('attendance.start'));
    $end = \Illuminate\Support\Carbon::parse(config('attendance.end'));
    $breakMinutes = config('attendance.break_minutes');
    $expectedHours = ($start->diffInMinutes($end) - $breakMinutes) / 60;
@endphp

<x-layouts.portal title="Employee Portal" heading="Dashboard" :on-duty="$state === 'on-duty'">
    @unless ($employee)
        @include('employee._not-linked')
    @else
        {{-- ============ WELCOME ============ --}}
        <section class="mb-6">
            <p class="eyebrow mb-2">Today's Attendance</p>
            <h2 class="text-2xl font-bold sm:text-3xl">{{ $greeting }}, {{ $employee->first_name }}.</h2>
            <p class="mt-1 text-sm text-white/65">Manage your attendance and work session.</p>
        </section>

        {{-- ============ EMPLOYEE INFO ============ --}}
        <x-card class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <x-avatar :src="$employee->picture_url" :initials="$employee->initials" />
                <div>
                    <h3 class="font-bold">{{ $employee->full_name }}</h3>
                    <p class="text-xs text-white/55">Employee No. {{ $employee->employee_number }}</p>
                    <p class="text-xs text-white/55">{{ $employee->department }}</p>
                </div>
            </div>
            <div class="sm:text-right">
                <span class="mb-1 block text-[0.65rem] uppercase tracking-wider text-white/50">Current Status</span>
                <span class="flex items-center gap-2 text-sm font-bold sm:justify-end">
                    <span class="size-2 rounded-full {{ $dotColor }}"></span>{{ $statusLabel }}
                </span>
            </div>
        </x-card>

        {{-- ============ ATTENDANCE + SCHEDULE ============ --}}
        <div class="mb-5 grid gap-5 lg:grid-cols-[minmax(0,1.5fr)_minmax(280px,0.8fr)]">
            <x-card class="flex min-h-[400px] flex-col items-center justify-center text-center">
                <p class="eyebrow mb-3">Attendance</p>
                <h2 class="text-lg font-bold">Today's Work Session</h2>

                <div class="my-8">
                    <span class="mb-2 block text-[0.65rem] text-white/50">CURRENT TIME</span>
                    <strong data-live-clock class="block text-[clamp(2rem,5vw,3.3rem)] font-bold tracking-wide [text-shadow:0_0_15px_rgba(104,212,255,0.15)]">{{ now()->format('h:i:s A') }}</strong>
                    <span data-live-date class="mt-2 block text-xs text-white/55">{{ now()->format('F j, Y') }}</span>
                </div>

                <div class="mb-6 grid w-full max-w-[420px] grid-cols-[1fr_1px_1fr] items-center border-y border-white/12 py-4">
                    <div>
                        <span class="mb-1 block text-[0.65rem] uppercase text-white/50">Clock In</span>
                        <strong class="text-sm">{{ $today?->time_in_label ?? '—' }}</strong>
                    </div>
                    <div class="h-8 bg-white/15"></div>
                    <div>
                        <span class="mb-1 block text-[0.65rem] uppercase text-white/50">Clock Out</span>
                        <strong class="text-sm">{{ $today?->time_out_label ?? '—' }}</strong>
                    </div>
                </div>

                {{-- The real form. The confirm button in the modal submits it. --}}
                <form id="clock-form" method="POST" action="{{ route('employee.clock') }}">@csrf</form>

                <button type="button" class="btn-primary w-full max-w-[420px]" data-modal-open="confirm-clock" @disabled($state === 'complete')>
                    {{ ['not-clocked-in' => 'Clock In', 'on-duty' => 'Clock Out', 'complete' => 'Workday Complete'][$state] }}
                </button>
                <p class="mt-3 text-xs text-white/45">
                    {{ ['not-clocked-in' => 'Start your work session for today.', 'on-duty' => 'You are currently on duty.', 'complete' => 'Your attendance for today is complete.'][$state] }}
                </p>
            </x-card>

            <x-card eyebrow="Today" title="Work Schedule">
                <x-slot:action>
                    <span class="rounded border border-hexa-cyan/25 bg-hexa-cyan/8 px-2 py-1 text-[0.6rem] font-bold text-hexa-cyan">REGULAR</span>
                </x-slot:action>

                <div class="mb-8 flex items-center gap-4">
                    <div class="flex-1">
                        <span class="mb-1 block text-[0.65rem] text-white/50">START</span>
                        <strong>{{ $start->format('g:i A') }}</strong>
                    </div>
                    <div class="h-px flex-1 bg-white/20"></div>
                    <div class="flex-1 text-right">
                        <span class="mb-1 block text-[0.65rem] text-white/50">END</span>
                        <strong>{{ $end->format('g:i A') }}</strong>
                    </div>
                </div>

                <dl class="text-xs">
                    <div class="flex justify-between border-t border-white/10 py-3"><dt class="text-white/55">Break</dt><dd class="font-bold">{{ $breakMinutes }} minutes</dd></div>
                    <div class="flex justify-between border-t border-white/10 py-3"><dt class="text-white/55">Expected Hours</dt><dd class="font-bold">{{ rtrim(rtrim(number_format($expectedHours, 1), '0'), '.') }} hours</dd></div>
                </dl>
            </x-card>
        </div>

        {{-- ============ RECENT ATTENDANCE ============ --}}
        <x-card eyebrow="Activity" title="Recent Attendance">
            <x-slot:action>
                <a href="{{ route('employee.attendance') }}" class="text-xs text-hexa-cyan hover:text-hexa-cyan-light">View All →</a>
            </x-slot:action>
            <x-attendance-table :records="$recent" />
        </x-card>

        {{-- ============ CONFIRMATION MODAL ============ --}}
        <x-modal id="confirm-clock">
            <div class="mb-4 flex size-13 items-center justify-center rounded-lg border border-hexa-cyan/30 bg-hexa-cyan/8 text-xl text-hexa-cyan">◷</div>
            <h2 class="mb-2 text-lg font-bold">Confirm {{ $isClockIn ? 'Clock In' : 'Clock Out' }}</h2>
            <p class="mb-5 text-sm leading-relaxed text-white/60">
                Are you sure you want to {{ $isClockIn ? 'clock in and start' : 'clock out and end' }} your work session?
            </p>

            <dl class="mb-5 rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-xs">
                <div class="flex justify-between py-2"><dt class="text-white/45">Employee</dt><dd class="font-bold">{{ $employee->full_name }}</dd></div>
                <div class="flex justify-between py-2"><dt class="text-white/45">Date</dt><dd class="font-bold" data-live-date>{{ now()->format('F j, Y') }}</dd></div>
                <div class="flex justify-between py-2"><dt class="text-white/45">Time</dt><dd class="font-bold" data-live-clock="short">{{ now()->format('h:i A') }}</dd></div>
            </dl>

            <div class="grid gap-2 sm:grid-cols-2">
                <button type="button" class="btn-ghost" data-modal-close>Cancel</button>
                <button type="submit" form="clock-form" class="btn-primary">Confirm {{ $isClockIn ? 'Clock In' : 'Clock Out' }}</button>
            </div>
        </x-modal>

        {{-- ============ SUCCESS MODAL (after the form posts back) ============ --}}
        @if ($clock = session('clock'))
            @php
                $title = ['in' => 'Clock In Successful', 'out' => 'Clock Out Successful', 'done' => 'Already Complete'][$clock['action']];
                $message = ['in' => 'Your work session has started.', 'out' => 'Your work session has ended.', 'done' => 'Your attendance for today is already complete.'][$clock['action']];
            @endphp
            <x-modal id="clock-success" data-auto-open data-auto-close="3000">
                <div class="text-center">
                    <div class="mx-auto mb-4 flex size-16 items-center justify-center rounded-full border border-hexa-green/35 bg-hexa-green/10 text-3xl text-hexa-green">✓</div>
                    <h2 class="mb-2 text-lg font-bold">{{ $title }}</h2>
                    <p class="mb-4 text-sm text-white/55">{{ $message }}</p>
                    <strong class="mb-5 block text-2xl text-hexa-cyan">{{ $clock['time'] }}</strong>
                    <div class="animate-shrink h-0.5 w-full bg-hexa-cyan"></div>
                </div>
            </x-modal>
        @endif
    @endunless
</x-layouts.portal>
