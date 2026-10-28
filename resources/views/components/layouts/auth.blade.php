{{-- Layout for guest pages: Login, Register. Usage: <x-layouts.auth title="Login"> ... </x-layouts.auth> --}}
@props(['title' => 'HexaHub'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HexaHub | {{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body id="trail-stage" class="isolate">
    <x-background dim="from-hexa-night/35 to-hexa-night/45" />

    <main class="flex min-h-screen items-center justify-center px-4 py-8">
        <div class="flex w-full max-w-[430px] flex-col items-center">
            <a href="{{ route('login') }}" aria-label="HexaHub home" class="mb-6">
                <img src="{{ asset('images/hexahub.png') }}" alt="HexaHub"
                     class="w-[min(330px,82vw)] [image-rendering:pixelated] drop-shadow-[0_0_6px_rgba(104,212,255,0.35)]">
            </a>

            <section class="glass w-full px-6 py-7 sm:px-9">
                {{ $slot }}
            </section>

            <footer class="mt-6 text-sm text-white [text-shadow:1px_1px_3px_rgb(0_0_0/0.7)]">Group 7</footer>
        </div>
    </main>

    {{ $after ?? '' }}
</body>
</html>
