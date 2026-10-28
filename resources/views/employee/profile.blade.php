<x-layouts.portal title="Profile">
    @unless ($employee)
        @include('employee._not-linked')
    @else
        <div class="grid gap-5 lg:grid-cols-[320px_minmax(0,1fr)]">
            <x-card class="flex flex-col items-center text-center">
                <x-avatar :src="$employee->picture_url" :initials="$employee->initials" size="lg" class="mb-4" />
                <h2 class="text-lg font-bold">{{ $employee->full_name }}</h2>
                <p class="text-xs text-white/55">{{ $employee->department }}</p>

                <div class="mt-6 grid w-full grid-cols-2 gap-3">
                    <div class="rounded-lg border border-white/10 bg-white/5 p-3">
                        <p class="text-2xl font-bold text-hexa-green">{{ $daysPresent }}</p>
                        <p class="text-[0.65rem] uppercase text-white/50">Days logged</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/5 p-3">
                        <p class="text-2xl font-bold text-hexa-amber">{{ $daysLate }}</p>
                        <p class="text-[0.65rem] uppercase text-white/50">Days late</p>
                    </div>
                </div>
            </x-card>

            <x-card eyebrow="Details" title="Employee Information">
                <dl class="text-sm">
                    @foreach ([
                        'Employee Number' => $employee->employee_number,
                        'First Name' => $employee->first_name,
                        'Last Name' => $employee->last_name,
                        'Department' => $employee->department,
                        'Email' => $user?->email,
                        'Username' => $user?->username,
                        'Registered' => $employee->created_at?->format('F j, Y'),
                    ] as $label => $value)
                        <div class="flex justify-between gap-4 border-t border-white/10 py-3 first:border-t-0">
                            <dt class="text-white/55">{{ $label }}</dt>
                            <dd class="text-right font-bold">{{ $value ?? '—' }}</dd>
                        </div>
                    @endforeach
                </dl>
            </x-card>
        </div>
    @endunless
</x-layouts.portal>
