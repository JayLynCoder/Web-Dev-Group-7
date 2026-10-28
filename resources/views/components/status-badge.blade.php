@props(['status'])

@php
    $styles = [
        'present' => ['PRESENT', 'border-hexa-green/25 bg-hexa-green/12 text-hexa-green'],
        'late' => ['LATE', 'border-hexa-amber/25 bg-hexa-amber/12 text-hexa-amber'],
        'on-duty' => ['ON DUTY', 'border-hexa-cyan/25 bg-hexa-cyan/12 text-hexa-cyan'],
    ];
    [$label, $classes] = $styles[$status] ?? [strtoupper($status), 'border-white/20 bg-white/10 text-white'];
@endphp

<span class="inline-block rounded border px-2 py-1 text-[0.65rem] font-bold {{ $classes }}">{{ $label }}</span>
