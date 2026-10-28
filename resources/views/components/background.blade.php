{{-- Looping background video + dark overlay used on every page. --}}
@props(['dim' => 'from-hexa-night/60 to-hexa-night/75'])

<video class="pointer-events-none fixed inset-0 -z-20 h-full w-full object-cover" autoplay muted loop playsinline aria-hidden="true">
    <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">
</video>
<div class="pointer-events-none fixed inset-0 -z-10 bg-gradient-to-b {{ $dim }}" aria-hidden="true"></div>
