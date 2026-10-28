<x-layouts.portal title="Employees">
    <x-card eyebrow="Directory" title="Employees">
        <x-slot:action>
            <a href="{{ route('admin.employees.create') }}" class="btn-primary min-h-9 text-xs">+ Register Employee</a>
        </x-slot:action>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[560px] text-left text-sm">
                <thead class="bg-white/5 text-[0.65rem] uppercase tracking-wider text-white/50">
                    <tr>
                        <th class="px-4 py-3 font-normal">Employee</th>
                        <th class="px-4 py-3 font-normal">Number</th>
                        <th class="px-4 py-3 font-normal">Department</th>
                        <th class="px-4 py-3 font-normal">Portal Login</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/8 text-white/80">
                    @forelse ($employees as $employee)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <x-avatar :src="$employee->picture_url" :initials="$employee->initials" size="sm" />
                                    <span class="text-white">{{ $employee->full_name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ $employee->employee_number }}</td>
                            <td class="px-4 py-3">{{ $employee->department }}</td>
                            <td class="px-4 py-3 text-xs">{{ $employee->user?->email ?? 'Kiosk only' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-white/50">No employees yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</x-layouts.portal>
