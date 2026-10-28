<x-layouts.auth title="Register">
    <h1 class="sr-only">Create a HexaHub account</h1>

    <x-flash />

    <form action="{{ route('register.submit') }}" method="POST">
        @csrf
        <x-form.input name="username" label="Username" icon="★" autocomplete="username" placeholder="Choose a username" required />
        <x-form.input name="email" id="register-email" type="email" label="Email" icon="✉︎" autocomplete="email" placeholder="Enter your email" required />
        <x-form.input name="password" id="register-password" type="password" label="Password" icon="🔒︎" autocomplete="new-password" placeholder="Create a password" aria-describedby="password-requirements" required />
        <x-form.input name="password_confirmation" id="password-confirmation" type="password" label="Confirm Password" icon="🔒︎" autocomplete="new-password" placeholder="Confirm your password" required />
        <p id="password-match" class="-mt-3 mb-4 text-xs" aria-live="polite"></p>

        {{-- Updated live by resources/js/forms.js --}}
        <section id="password-requirements" class="mb-5 rounded-lg border border-white/15 bg-white/5 p-4">
            <h2 class="mb-2 text-xs font-bold">Password requirements</h2>
            <ul class="space-y-1 text-xs">
                @foreach (['length' => 'At least 8 characters', 'uppercase' => 'At least 1 uppercase letter', 'lowercase' => 'At least 1 lowercase letter', 'number' => 'At least 1 number', 'special' => 'At least 1 special character'] as $key => $text)
                    <li id="requirement-{{ $key }}" class="text-white/50 transition-colors">
                        <span data-icon class="inline-block w-4 font-bold" aria-hidden="true">○</span>{{ $text }}
                    </li>
                @endforeach
            </ul>
        </section>

        <button type="submit" class="btn-primary w-full">Register</button>
    </form>

    <p class="mt-5 text-center text-xs [text-shadow:1px_1px_3px_rgb(0_0_0/0.7)]">
        Already have an account?
        <a href="{{ route('login') }}" class="font-bold text-hexa-cyan hover:text-hexa-cyan-light">Log in here</a>
    </p>

    <x-slot:after>
        @if (session('registration_success'))
            <x-modal id="registration-success" data-auto-open>
                <div class="text-center">
                    <div class="mx-auto mb-4 flex size-16 items-center justify-center rounded-full border border-hexa-green/35 bg-hexa-green/10 text-3xl text-hexa-green">✓</div>
                    <h2 class="mb-2 text-lg font-bold">Registration Successful!</h2>
                    <p class="mb-5 text-sm text-white/60">Your HexaHub account has been created. You can now sign in.</p>
                    <a href="{{ route('login') }}" class="btn-primary w-full">Sign In</a>
                </div>
            </x-modal>
        @endif
    </x-slot:after>
</x-layouts.auth>
