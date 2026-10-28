<x-layouts.portal title="Dashboard">
    <section class="mb-6">
        <p class="eyebrow mb-2">Overview</p>
        <h2 class="text-2xl font-bold sm:text-3xl">Welcome back, {{ session('full_name') }}.</h2>
        <p class="mt-1 text-sm text-white/65">Here's today's attendance at a glance.</p>
    </section>

    <div class="mb-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        <x-stat label="Employees" :value="$stats['employees']" />
        <x-stat label="Present Today" :value="$stats['present']" tone="text-hexa-green" />
        <x-stat label="On Duty Now" :value="$stats['onDuty']" tone="text-hexa-cyan" />
        <x-stat label="Late Today" :value="$stats['late']" tone="text-hexa-amber" />
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
        <x-card eyebrow="Today" title="Attendance">
            <x-slot:action>
                <a href="{{ route('admin.logs') }}" class="text-xs text-hexa-cyan hover:text-hexa-cyan-light">View all logs →</a>
            </x-slot:action>
            <x-attendance-table :records="$today" show-employee empty="Nobody has clocked in yet today." />
        </x-card>

        <x-card eyebrow="About" title="Group 7">
            <p class="mb-4 text-sm text-white/65">This website was developed by the members of Group 7.</p>
            <ul class="space-y-2 text-sm">
                @foreach ($members as $member)
                    <li class="rounded-lg border border-white/10 bg-white/5 px-3 py-2">{{ $member }}</li>
                @endforeach
            </ul>
        </x-card>
    </div>
</x-layouts.portal>
