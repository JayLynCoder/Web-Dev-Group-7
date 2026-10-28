@props(['label', 'value', 'tone' => 'text-white'])

<div class="glass p-5">
    <p class="text-[0.68rem] uppercase tracking-wider text-white/50">{{ $label }}</p>
    <p class="mt-2 text-3xl font-bold {{ $tone }}">{{ $value }}</p>
</div>
