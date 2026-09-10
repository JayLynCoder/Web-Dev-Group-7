<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <meta
        name="description"
        content="Log in to HexaHub"
    >

    <title>HexaHub | Login</title>
    @vite(['resources/css/auth.css'])
</head>

<body>
    <!-- Background video -->
    <video
        class="background-video"
        autoplay
        muted
        loop
        playsinline
        aria-hidden="true"
    >
        <source
            src="{{ asset('videos/background.mp4') }}"
            type="video/mp4"
        >
    </video>

    <div
        class="background-overlay"
        aria-hidden="true"
    ></div>


    <!-- Main content -->
    <main class="auth-page">

        <div class="auth-content">
            <header class="brand">

                <a
                    href="/"
                    aria-label="HexaHub Home"
                >
                    <img
                        src="{{ asset('images/hexahub.png') }}"
                        alt="HexaHub"
                        class="brand__logo"
                    >
                </a>

            </header>


            <!-- Login -->
            <section
                class="auth-section"
                aria-labelledby="login-title"
            >

                <article class="auth-card">

                    <h1
                        id="login-title"
                        class="sr-only"
                    >
                        Log in to HexaHub
                    </h1>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div style="color: #68d4ff; font-size: 0.8rem; margin-bottom: 1rem; text-align: center;">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form
                        class="auth-form"
                        action="{{ route('login') }}"
                        method="POST"
                    >
                        @csrf

                        <fieldset class="auth-fields">

                            <legend class="sr-only">
                                Login information
                            </legend>


                            <!-- Email -->
                            <p class="form-field">

                                <label for="email">
                                    Email
                                </label>

                                <span class="input-group">

                                    <span
                                        class="input-icon"
                                        aria-hidden="true"
                                    >
                                        ✉︎
                                    </span>

                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        autocomplete="email"
                                        placeholder="Enter your email"
                                        required
                                        autofocus
                                    >

                                </span>

                                @error('email')
                                    <span style="color: #ff6b6b; font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </p>


                            <!-- Password -->
                            <p class="form-field">

                                <label for="password">
                                    Password
                                </label>

                                <span class="input-group">

                                    <span
                                        class="input-icon"
                                        aria-hidden="true"
                                    >
                                        🔒︎
                                    </span>

                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        autocomplete="current-password"
                                        placeholder="Enter your password"
                                        required
                                    >

                                </span>

                                @error('password')
                                    <span style="color: #ff6b6b; font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </p>


                            <!-- Remember Me -->
                            <p class="form-field" style="display: flex; align-items: center; gap: 0.5rem;">
                                <input
                                    type="checkbox"
                                    id="remember_me"
                                    name="remember"
                                    style="width: auto; height: auto;"
                                >
                                <label for="remember_me" style="margin-bottom: 0; cursor: pointer;">
                                    Remember me
                                </label>
                            </p>


                            <!-- Login button -->
                            <button
                                type="submit"
                                class="auth-button"
                            >
                                Log In
                            </button>

                        </fieldset>

                    </form>


                    <!-- Register link -->
                    <p class="account-switch">

                        Don't have an account?

                        <a href="{{ route('register') }}">
                            Register here
                        </a>

                    </p>

                </article>

            </section>


            <!-- Footer -->
            <footer class="site-footer">

                <p>
                    Group 7
                </p>

            </footer>

        </div>

    </main>

</body>

</html>