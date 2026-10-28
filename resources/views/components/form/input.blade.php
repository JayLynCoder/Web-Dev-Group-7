{{-- Label + (optional icon) + input. Example: <x-form.input name="email" type="email" label="Email" icon="✉︎" /> --}}
@props(['name', 'label', 'type' => 'text', 'icon' => null, 'id' => null, 'dark' => false])

@php $id ??= $name; @endphp

<div class="mb-5">
    <label for="{{ $id }}" class="mb-2 block text-xs font-bold tracking-wide text-white [text-shadow:1px_1px_3px_rgb(0_0_0/0.7)]">{{ $label }}</label>
    <div class="relative">
        @if ($icon)
            <span class="pointer-events-none absolute top-1/2 left-3.5 -translate-y-1/2 text-[#34384d]" aria-hidden="true">{{ $icon }}</span>
        @endif
        <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}"
               @if ($type !== 'password' && $type !== 'file') value="{{ old($name) }}" @endif
               {{ $attributes->class(['field', 'pl-10' => $icon, 'border-hexa-red' => $errors->has($name)]) }}>
    </div>
    @error($name)
        <p class="mt-1.5 text-xs text-hexa-red">{{ $message }}</p>
    @enderror
</div>
