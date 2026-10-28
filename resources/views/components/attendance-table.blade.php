{{--
    Attendance records table, reused on 4 pages.
    <x-attendance-table :records="$records" />                    (employee pages)
    <x-attendance-table :records="$records" show-employee />      (admin pages)
--}}
@props(['records', 'showEmployee' => false, 'empty' => 'No attendance records yet.'])

<div class="overflow-x-auto">
    <table class="w-full min-w-[560px] text-left text-sm">
        <thead class="bg-white/5 text-[0.65rem] uppercase tracking-wider text-white/50">
            <tr>
                @if ($showEmployee)<th class="px-4 py-3 font-normal">Employee</th>@endif
                <th class="px-4 py-3 font-normal">Date</th>
                <th class="px-4 py-3 font-normal">Clock In</th>
                <th class="px-4 py-3 font-normal">Clock Out</th>
                <th class="px-4 py-3 font-normal">Total</th>
                <th class="px-4 py-3 font-normal">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/8 text-white/80">
            @forelse ($records as $record)
                <tr>
                    @if ($showEmployee)
                        <td class="px-4 py-3">
                            <span class="block text-white">{{ $record->employee->full_name }}</span>
                            <span class="text-xs text-white/50">{{ $record->employee->employee_number }}</span>
                        </td>
                    @endif
                    <td class="px-4 py-3">{{ $record->attendance_date->format('F j, Y') }}</td>
                    <td class="px-4 py-3">{{ $record->time_in_label }}</td>
                    <td class="px-4 py-3">{{ $record->time_out_label }}</td>
                    <td class="px-4 py-3">{{ $record->total_label }}</td>
                    <td class="px-4 py-3"><x-status-badge :status="$record->status" /></td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $showEmployee ? 6 : 5 }}" class="px-4 py-8 text-center text-white/50">{{ $empty }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
