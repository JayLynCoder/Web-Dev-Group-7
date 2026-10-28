{{--
    Layout for every logged-in page (Admin + Employee Portal).
    Usage:
        <x-layouts.portal title="Dashboard" heading="Dashboard"> ... </x-layouts.portal>
    Props:
        title    – browser tab title
        heading  – big title in the top bar
        onDuty   – true when an employee is clocked in (warns before signing out)
--}}
@props(['title' => 'HexaHub', 'heading' => null, 'onDuty' => false])

@php
    $isAdmin = (bool) session('is_admin');
    $name = session('full_name', 'User');
    $initials = collect(explode(' ', $name))->filter()->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->join('');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HexaHub | {{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body id="trail-stage" class="isolate">
    <x-background />

    {{-- ================= SIDEBAR ================= --}}
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-30 flex w-64 -translate-x-full flex-col border-r border-white/20 bg-hexa-night/70 p-6 shadow-2xl backdrop-blur-xl transition-transform lg:translate-x-0">
        <a href="{{ route('dashboard') }}" class="mb-5 flex justify-center border-b border-white/15 pb-6">
            <img src="{{ asset('images/hexahub.png') }}" alt="HexaHub"
                 class="w-44 [image-rendering:pixelated] drop-shadow-[0_0_7px_rgba(104,212,255,0.35)]">
        </a>

        <p class="eyebrow mb-5 text-center">{{ $isAdmin ? 'Admin Panel' : 'Employee Portal' }}</p>

        <nav class="flex flex-col gap-1.5">
            @if ($isAdmin)
                <x-nav-link :href="route('admin.dashboard')" icon="▣" :active="request()->routeIs('admin.dashboard')">Dashboard</x-nav-link>
                <x-nav-link :href="route('admin.attendance')" icon="◷" :active="request()->routeIs('admin.attendance')">Record Attendance</x-nav-link>
                <x-nav-link :href="route('admin.logs')" icon="☰" :active="request()->routeIs('admin.logs')">Attendance Logs</x-nav-link>
                <x-nav-link :href="route('admin.employees.index')" icon="◉" :active="request()->routeIs('admin.employees.index')">Employees</x-nav-link>
                <x-nav-link :href="route('admin.employees.create')" icon="+" :active="request()->routeIs('admin.employees.create')">Register Employee</x-nav-link>
            @else
                <x-nav-link :href="route('employee.dashboard')" icon="▣" :active="request()->routeIs('employee.dashboard')">Dashboard</x-nav-link>
                <x-nav-link :href="route('employee.attendance')" icon="◷" :active="request()->routeIs('employee.attendance')">My Attendance</x-nav-link>
                <x-nav-link :href="route('employee.profile')" icon="◉" :active="request()->routeIs('employee.profile')">Profile</x-nav-link>
            @endif
        </nav>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-auto" data-on-duty="{{ $onDuty ? 'true' : 'false' }}">
            @csrf
            <button type="submit" class="btn-ghost w-full text-xs">↪&nbsp; Sign Out</button>
        </form>
    </aside>

    {{-- ================= MAIN ================= --}}
    <main class="min-h-screen p-4 sm:p-6 lg:ml-64 lg:p-8">
        <header class="mb-8 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <button type="button" data-sidebar-toggle aria-label="Open menu"
                        class="rounded-md border border-white/20 bg-white/10 px-3 py-2 lg:hidden">☰</button>
                <div>
                    <p class="eyebrow mb-1">{{ $isAdmin ? 'Admin Panel' : 'Employee Portal' }}</p>
                    <h1 class="text-xl font-bold sm:text-2xl">{{ $heading ?? $title }}</h1>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <x-avatar :initials="$initials" size="sm" />
                <div class="hidden flex-col sm:flex">
                    <strong class="text-sm">{{ $name }}</strong>
                    <span class="text-xs text-white/55">{{ $isAdmin ? 'Administrator' : 'Employee' }}</span>
                </div>
            </div>
        </header>

        {{ $slot }}

        <footer class="mt-10 text-center text-xs text-white/40">&copy; {{ date('Y') }} HexaHub | Group 7</footer>
    </main>

    {{-- Shown by resources/js/employee.js when signing out while clocked in --}}
    @if ($onDuty)
        <x-modal id="logout-warning">
            <div class="mb-4 flex size-13 items-center justify-center rounded-lg border border-hexa-amber/30 bg-hexa-amber/10 text-xl text-hexa-amber">!</div>
            <h2 class="mb-2 text-lg font-bold">You're still on duty</h2>
            <p class="mb-5 text-sm leading-relaxed text-white/60">
                You haven't clocked out yet. Signing out will <strong class="text-white">not</strong> record a clock-out.
            </p>
            <div class="grid gap-2 sm:grid-cols-2">
                <button type="button" class="btn-ghost" data-modal-close>Stay</button>
                <button type="button" class="btn-primary" id="logout-anyway">Sign Out Anyway</button>
            </div>
        </x-modal>
    @endif

    {{ $after ?? '' }}
</body>
</html>
