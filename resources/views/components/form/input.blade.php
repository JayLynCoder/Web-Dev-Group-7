{{--
    Label + (optional icon) + input + error message, in one tag.
      <x-form.input name="email" type="email" label="Email" icon="✉︎" required />
      <x-form.input name="username" label="Username" :value="$user->username" />   (edit forms)
    Any extra attribute (placeholder, required, pattern, autofocus…) is passed to the <input>.
--}}
@props(['name', 'label', 'type' => 'text', 'icon' => null, 'id' => null, 'value' => null, 'hint' => null])

@php $id ??= $name; @endphp

<div class="mb-5">
    <label for="{{ $id }}" class="mb-2 block text-xs font-bold tracking-wide text-white [text-shadow:1px_1px_3px_rgb(0_0_0/0.7)]">{{ $label }}</label>
    <div class="relative">
        @if ($icon)
            <span class="pointer-events-none absolute top-1/2 left-3.5 -translate-y-1/2 text-[#34384d]" aria-hidden="true">{{ $icon }}</span>
        @endif
        <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}"
               @if ($type !== 'password' && $type !== 'file') value="{{ old($name, $value) }}" @endif
               {{ $attributes->class(['field', 'pl-10' => $icon, 'border-hexa-red' => $errors->has($name)]) }}>
    </div>
    @if ($hint)
        <p class="mt-1.5 text-xs text-white/50">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="mt-1.5 text-xs text-hexa-red">{{ $message }}</p>
    @enderror
</div>
