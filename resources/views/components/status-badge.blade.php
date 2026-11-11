{{-- Small coloured label. <x-status-badge status="complete" /> --}}
@props(['status'])

@php
    $styles = [
        'complete'    => ['COMPLETE', 'border-hexa-green/25 bg-hexa-green/12 text-hexa-green'],
        'timed-in'    => ['TIMED IN', 'border-hexa-cyan/25 bg-hexa-cyan/12 text-hexa-cyan'],
        'no-time-out' => ['NO TIME OUT', 'border-hexa-amber/25 bg-hexa-amber/12 text-hexa-amber'],
        'superadmin'  => ['SUPER ADMIN', 'border-hexa-amber/25 bg-hexa-amber/12 text-hexa-amber'],
        'admin'       => ['ADMIN', 'border-hexa-cyan/25 bg-hexa-cyan/12 text-hexa-cyan'],
        'student'     => ['STUDENT', 'border-white/20 bg-white/8 text-white/80'],
    ];

    [$label, $classes] = $styles[$status] ?? [strtoupper($status), 'border-white/20 bg-white/10 text-white'];
@endphp

<span class="inline-block rounded border px-2 py-1 text-[0.65rem] font-bold whitespace-nowrap {{ $classes }}">{{ $label }}</span>
