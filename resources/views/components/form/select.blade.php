{{--
    Label + dropdown + error message.
      <x-form.select name="role" label="Role"> <option ...>...</option> </x-form.select>
--}}
@props(['name', 'label', 'id' => null, 'hint' => null])

@php $id ??= $name; @endphp

<div class="mb-5">
    <label for="{{ $id }}" class="mb-2 block text-xs font-bold tracking-wide text-white">{{ $label }}</label>
    <select id="{{ $id }}" name="{{ $name }}" {{ $attributes->class(['field cursor-pointer', 'border-hexa-red' => $errors->has($name)]) }}>
        {{ $slot }}
    </select>
    @if ($hint)
        <p class="mt-1.5 text-xs text-white/50">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="mt-1.5 text-xs text-hexa-red">{{ $message }}</p>
    @enderror
</div>
