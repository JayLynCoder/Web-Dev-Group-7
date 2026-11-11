{{-- Login page. Uses the guest layout: components/layouts/auth.blade.php --}}
<x-layouts.auth title="Login">
    <h1 class="sr-only">Log in to HexaHub</h1>

    <x-flash :skip="['email', 'password']" />

    <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <x-form.input name="email" type="email" label="Email" icon="✉︎" autocomplete="email" placeholder="Enter your email" required autofocus />
        <x-form.input name="password" type="password" label="Password" icon="🔒︎" autocomplete="current-password" placeholder="Enter your password" required />

        <button type="submit" class="btn-primary mt-1 w-full">Log In</button>
    </form>

    <p class="mt-5 text-center text-xs [text-shadow:1px_1px_3px_rgb(0_0_0/0.7)]">
        Don't have an account yet?
        <a href="{{ route('register') }}" class="font-bold text-hexa-cyan hover:text-hexa-cyan-light">Create Account</a>
    </p>
</x-layouts.auth>
