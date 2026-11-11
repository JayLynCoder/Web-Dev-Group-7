{{--
    Success message + error messages for the whole page.
      <x-flash />                                  shows every error
      <x-flash :skip="['email', 'password']" />    skips errors already shown under those inputs
--}}
@props(['skip' => []])

@php
    $messages = collect($errors->getMessages())->except($skip)->flatten();
@endphp

@if (session('status'))
    <p role="status" class="mb-5 rounded-lg border border-hexa-green/30 bg-hexa-green/10 px-4 py-3 text-sm text-hexa-green">
        ✓ {{ session('status') }}
    </p>
@endif

@if ($messages->isNotEmpty())
    <div role="alert" class="mb-5 rounded-lg border border-hexa-red/30 bg-hexa-red/10 px-4 py-3 text-sm text-hexa-red">
        @foreach ($messages as $message)
            <p>{{ $message }}</p>
        @endforeach
    </div>
@endif
