@php
    $scanned = session('scanned_employee_id') ? \App\Models\Employee::find(session('scanned_employee_id')) : null;
@endphp

<x-layouts.portal title="Record Attendance">
    <div class="mx-auto max-w-xl">
        <x-card eyebrow="Kiosk" title="Record Employee Attendance">
            <p class="mb-5 text-sm text-white/60">Type or scan an employee number. First scan = time in, second scan = time out.</p>

            <x-flash />

            @if ($scanned)
                {{-- Disappears after 3 s so the next person can scan --}}
                <div class="mb-5 flex items-center gap-4 rounded-xl border border-hexa-cyan/25 bg-hexa-cyan/8 p-4 transition-opacity duration-500"
                     id="employee-preview">
                    <x-avatar :src="$scanned->picture_url" :initials="$scanned->initials" />
                    <div>
                        <p class="font-bold">{{ $scanned->full_name }}</p>
                        <p class="text-xs text-white/60">{{ $scanned->employee_number }} · {{ $scanned->department }}</p>
                    </div>
                </div>
                <script>setTimeout(() => document.getElementById('employee-preview')?.remove(), 3000);</script>
            @endif

            <form method="POST" action="{{ route('admin.attendance.record') }}">
                @csrf
                <x-form.input name="employeeId" label="Employee Number" icon="#" placeholder="e.g. HH-2026-001" autocomplete="off" autofocus required />
                <button type="submit" class="btn-primary w-full">Submit</button>
            </form>
        </x-card>
    </div>
</x-layouts.portal>
