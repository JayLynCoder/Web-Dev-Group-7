{{-- Circle with the employee photo, or initials if there is no photo. --}}
@props(['src' => null, 'initials' => '?', 'size' => 'md'])

@php
    $sizes = ['sm' => 'size-10 text-xs', 'md' => 'size-13 text-sm', 'lg' => 'size-24 text-2xl'];
@endphp

<div {{ $attributes->class(['flex shrink-0 items-center justify-center overflow-hidden rounded-full border border-hexa-cyan/35 bg-hexa-cyan/10 font-bold text-hexa-cyan', $sizes[$size]]) }}>
    @if ($src)
        <img src="{{ $src }}" alt="" class="size-full object-cover">
    @else
        {{ $initials }}
    @endif
</div>
