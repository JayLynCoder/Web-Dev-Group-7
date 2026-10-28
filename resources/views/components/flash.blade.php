{{-- Success message + validation errors. Drop <x-flash /> into any form card. --}}
@if (session('status'))
    <p role="status" class="mb-5 rounded-lg border border-hexa-green/30 bg-hexa-green/10 px-4 py-3 text-sm text-hexa-green">
        {{ session('status') }}
    </p>
@endif

@if ($errors->any())
    <div role="alert" class="mb-5 rounded-lg border border-hexa-red/30 bg-hexa-red/10 px-4 py-3 text-sm text-hexa-red">
        <ul class="list-inside list-disc space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
