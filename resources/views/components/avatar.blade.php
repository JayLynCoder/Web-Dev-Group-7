{{--
    Round photo, or initials when there is no photo.
      <x-avatar :student="$student" />          (uses storage/students/<picture>)
      <x-avatar initials="JD" size="sm" />
--}}
@props(['student' => null, 'src' => null, 'initials' => '?', 'size' => 'md'])

@php
    if ($student) {
        $src ??= ! empty($student->picture) ? asset('storage/students/' . $student->picture) : null;
        $initials = strtoupper(mb_substr($student->first_name ?? '', 0, 1) . mb_substr($student->last_name ?? '', 0, 1));
    }

    $sizes = ['sm' => 'size-10 text-xs', 'md' => 'size-13 text-sm', 'lg' => 'size-24 text-2xl'];
@endphp

<div {{ $attributes->class(['flex shrink-0 items-center justify-center overflow-hidden rounded-full border border-hexa-cyan/35 bg-hexa-cyan/10 font-bold text-hexa-cyan', $sizes[$size]]) }}>
    @if ($src)
        <img src="{{ $src }}" alt="" class="size-full object-cover">
    @else
        {{ $initials }}
    @endif
</div>
