<x-layouts.portal title="Attendance Logs">
    <x-card eyebrow="Records" title="Attendance Logs">
        <x-slot:action>
            <form method="GET" class="flex items-center gap-2">
                <input type="date" name="date" value="{{ $date?->toDateString() }}" class="field h-9 w-auto text-xs">
                <button class="btn-ghost min-h-9 text-xs">Filter</button>
                @if ($date)
                    <a href="{{ route('admin.logs') }}" class="text-xs text-hexa-cyan">Clear</a>
                @endif
            </form>
        </x-slot:action>

        <x-attendance-table :records="$records" show-employee empty="No records found." />

        <div class="mt-5">{{ $records->links() }}</div>
    </x-card>
</x-layouts.portal>
