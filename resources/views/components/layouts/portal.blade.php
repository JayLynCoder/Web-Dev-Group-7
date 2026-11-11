{{--
|--------------------------------------------------------------------------
| Layout for every LOGGED-IN page (admin, super admin and student)
|--------------------------------------------------------------------------
| Usage:
|   <x-layouts.portal title="Attendance Logs"> ...page content... </x-layouts.portal>
|
| Props:
|   title    – browser tab title (also the big heading unless "heading" is given)
|   heading  – big title in the top bar
|   onDuty   – true when a student is timed in (warns before signing out)
--}}
@props(['title' => 'HexaHub', 'heading' => null, 'onDuty' => false])

@php
    $role = session('role', session('is_admin') ? 'admin' : 'student');
    $isAdmin = in_array($role, ['admin', 'superadmin'], true);
    $roleLabel = ['superadmin' => 'Super Admin', 'admin' => 'Admin', 'student' => 'Student'][$role] ?? 'User';
    $name = session('full_name', 'User');
    $initials = collect(explode(' ', $name))->filter()->map(fn ($part) => mb_substr($part, 0, 1))->take(2)->join('');
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

    {{-- ===================== SIDEBAR ===================== --}}
    {{-- Hidden off-screen on phones (-translate-x-full), always visible from lg (1024px) up --}}
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-30 flex w-64 -translate-x-full flex-col border-r border-white/20 bg-hexa-night/70 p-6 shadow-2xl backdrop-blur-xl transition-transform lg:translate-x-0">
        <a href="{{ route('dashboard') }}" class="mb-5 flex justify-center border-b border-white/15 pb-6">
            <img src="{{ asset('images/hexahub.png') }}" alt="HexaHub"
                 class="w-44 [image-rendering:pixelated] drop-shadow-[0_0_7px_rgba(104,212,255,0.35)]">
        </a>

        <p class="eyebrow mb-5 text-center">{{ $isAdmin ? 'Admin Panel' : 'Student Portal' }}</p>

        <nav class="flex flex-col gap-1.5" aria-label="Main navigation">
            @if ($isAdmin)
                <x-nav-link :href="route('attendance')" icon="◷" :active="request()->routeIs('attendance')">Record Attendance</x-nav-link>
                <x-nav-link :href="route('attendance.logs')" icon="☰" :active="request()->routeIs('attendance.logs')">Attendance Logs</x-nav-link>
                <x-nav-link :href="route('register-student')" icon="+" :active="request()->routeIs('register-student')">Register Student</x-nav-link>
                @if ($role === 'superadmin')
                    <x-nav-link :href="route('users.index')" icon="◉" :active="request()->routeIs('users.*')">Manage Users</x-nav-link>
                @endif
            @else
                <x-nav-link :href="route('student-attendance')" icon="▣" :active="request()->routeIs('student-attendance')">My Attendance</x-nav-link>
            @endif
        </nav>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto"
              @if ($onDuty)
                  data-confirm="You haven't timed out yet. Signing out will NOT record your time out."
                  data-confirm-button="Sign Out Anyway"
              @endif>
            @csrf
            <button type="submit" class="btn-ghost w-full text-xs">↪&nbsp; Sign Out</button>
        </form>
    </aside>

    {{-- ===================== MAIN AREA ===================== --}}
    <main class="min-h-screen p-4 sm:p-6 lg:ml-64 lg:p-8">
        <header class="mb-8 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <button type="button" data-sidebar-toggle aria-label="Open menu"
                        class="rounded-md border border-white/20 bg-white/10 px-3 py-2 lg:hidden">☰</button>
                <div>
                    <p class="eyebrow mb-1">{{ $isAdmin ? 'Admin Panel' : 'Student Portal' }}</p>
                    <h1 class="text-xl font-bold sm:text-2xl">{{ $heading ?? $title }}</h1>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <x-avatar :initials="$initials" size="sm" />
                <div class="hidden flex-col sm:flex">
                    <strong class="text-sm">{{ $name }}</strong>
                    <span class="text-xs text-white/55">{{ $roleLabel }}</span>
                </div>
            </div>
        </header>

        {{ $slot }}

        <footer class="mt-10 text-center text-xs text-white/40">&copy; {{ date('Y') }} HexaHub | Group 7</footer>
    </main>

    {{-- ===================== SHARED "ARE YOU SURE?" DIALOG ===================== --}}
    {{-- Opened by resources/js/modals.js for any <form data-confirm="..."> --}}
    <x-modal id="confirm-dialog">
        <div class="mb-4 flex size-13 items-center justify-center rounded-lg border border-hexa-amber/30 bg-hexa-amber/10 text-xl text-hexa-amber">!</div>
        <h2 class="mb-2 text-lg font-bold">Are you sure?</h2>
        <p class="mb-5 text-sm leading-relaxed text-white/60" data-confirm-message></p>
        <div class="grid gap-2 sm:grid-cols-2">
            <button type="button" class="btn-ghost" data-modal-close>Cancel</button>
            <button type="button" class="btn-primary" data-confirm-yes>Yes</button>
        </div>
    </x-modal>

    {{ $after ?? '' }}
</body>
</html>
