<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Username -->
        <div class="form-group">
            <label for="name" class="form-label">Username</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                </span>
                <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" placeholder="Choose a username" required autofocus autocomplete="name">
            </div>
            <x-input-error :messages="$errors->get('name')" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 0.25rem;" />
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </span>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autocomplete="email">
            </div>
            <x-input-error :messages="$errors->get('email')" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 0.25rem;" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </span>
                <input id="password" class="form-input" type="password" name="password" placeholder="Create a password" required autocomplete="new-password">
            </div>
            <x-input-error :messages="$errors->get('password')" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 0.25rem;" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </span>
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" placeholder="Confirm your password" required autocomplete="new-password">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" style="color: #ff6b6b; font-size: 0.75rem; margin-top: 0.25rem;" />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit">
            Register
        </button>
    </form>

    <p class="card-footer-text">
        Already have an account? <a href="{{ route('login') }}">Log in here</a>
    </p>
</x-guest-layout>