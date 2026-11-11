{{-- Glass card. Optional eyebrow + title header; extra content goes in the slot. --}}
@props(['eyebrow' => null, 'title' => null])

<section {{ $attributes->class('glass p-6') }}>
    @if ($eyebrow || $title || isset($action))
        <header class="mb-5 flex items-start justify-between gap-4">
            <div>
                @if ($eyebrow)<p class="eyebrow mb-1.5">{{ $eyebrow }}</p>@endif
                @if ($title)<h2 class="text-base font-bold">{{ $title }}</h2>@endif
            </div>
            {{ $action ?? '' }}
        </header>
    @endif

    {{ $slot }}
</section>
