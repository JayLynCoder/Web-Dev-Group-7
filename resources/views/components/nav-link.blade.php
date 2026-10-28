@props(['href', 'icon' => '•', 'active' => false])

<a href="{{ $href }}" @if ($active) aria-current="page" @endif
   {{ $attributes->class([
       'flex items-center gap-3 rounded-lg border px-3.5 py-3 text-sm transition',
       'border-hexa-cyan/35 bg-hexa-cyan/12 text-white shadow-[0_0_15px_rgba(104,212,255,0.08)]' => $active,
       'border-transparent text-white/70 hover:border-hexa-cyan/20 hover:bg-white/8 hover:text-white' => ! $active,
   ]) }}>
    <span class="w-5 text-center text-hexa-cyan" aria-hidden="true">{{ $icon }}</span>
    {{ $slot }}
</a>
