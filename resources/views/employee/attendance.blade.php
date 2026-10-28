<x-layouts.portal title="My Attendance">
    @unless ($employee)
        @include('employee._not-linked')
    @else
        <x-card eyebrow="History" title="My Attendance">
            <x-attendance-table :records="$records" />
            <div class="mt-5">{{ $records->links() }}</div>
        </x-card>
    @endunless
</x-layouts.portal>
