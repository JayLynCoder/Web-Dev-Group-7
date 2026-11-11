{{--
    Modal shell. Open with a button that has data-modal-open="{{ id }}",
    close with any element that has data-modal-close (see resources/js/modals.js).
    Add data-auto-open / data-auto-close="3000" as attributes when needed.
--}}
@props(['id'])

<div id="{{ $id }}" data-modal role="dialog" aria-modal="true"
     {{ $attributes->class('fixed inset-0 z-50 hidden items-center justify-center bg-hexa-night/70 p-4 backdrop-blur-sm') }}>
    <div class="w-full max-w-[430px] rounded-2xl border border-white/25 bg-[#0c0c30]/90 p-7 shadow-2xl shadow-black/50 backdrop-blur-xl">
        {{ $slot }}
    </div>
</div>
