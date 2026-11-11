{{--
|--------------------------------------------------------------------------
| Admin: Record Attendance (kiosk)
|--------------------------------------------------------------------------
| Type or scan a student number → AttendanceController@recordAttendance.
| After submitting, the controller sends back:
|   session('status')          success message (Time in / Time out recorded…)
|   $errors                    e.g. "Student number not found", 10-minute rule
|   session('scanned_student') the student that was scanned (shown for 3 s)
--}}
@php $scanned = session('scanned_student'); @endphp

<x-layouts.portal title="Record Attendance">
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">

        {{-- ============ KIOSK FORM ============ --}}
        <x-card eyebrow="Kiosk" title="Record Student Attendance">
            <p class="mb-5 text-sm text-white/60">
                Type or scan a student number. First scan = <strong class="text-white">time in</strong>,
                second scan (10+ minutes later) = <strong class="text-white">time out</strong>.
            </p>

            <x-flash :skip="['studentId']" />

            @if ($scanned)
                {{-- data-auto-hide: resources/js/modals.js removes this after 3 seconds --}}
                <div data-auto-hide="3000"
                     class="mb-5 flex items-center gap-4 rounded-xl border border-hexa-cyan/25 bg-hexa-cyan/8 p-4 transition-opacity duration-500">
                    <x-avatar :student="$scanned" size="lg" />
                    <div>
                        <p class="text-lg font-bold">{{ $scanned->first_name }} {{ $scanned->last_name }}</p>
                        <p class="text-xs text-white/60">{{ $scanned->student_number }}</p>
                        <p class="text-xs text-white/60">{{ $scanned->year_section }} · {{ $scanned->college_program }}</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('attendance.record') }}">
                @csrf
                <x-form.input name="studentId" label="Student Number" icon="#" placeholder="e.g. 2023-00001"
                              autocomplete="off" autofocus required />
                <button type="submit" class="btn-primary w-full">Submit</button>
            </form>
        </x-card>

        {{-- ============ SIDE INFO ============ --}}
        <div class="flex flex-col gap-6">
            <x-card eyebrow="Now" title="Current Time" class="text-center">
                <strong data-live-clock class="block text-3xl font-bold tracking-wide">{{ now()->format('h:i:s A') }}</strong>
                <span data-live-date class="mt-2 block text-xs text-white/55">{{ now()->format('F j, Y') }}</span>
            </x-card>

            <x-card eyebrow="About" title="Group 7">
                <p class="mb-4 text-sm text-white/65">This website was developed by the members of Group 7.</p>
                <ul class="space-y-2 text-sm">
                    @foreach (config('members') as $member)
                        <li class="rounded-lg border border-white/10 bg-white/5 px-3 py-2">{{ $member }}</li>
                    @endforeach
                </ul>
            </x-card>
        </div>
    </div>
</x-layouts.portal>
