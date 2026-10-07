<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Log in to HexaHub">

    <title>HexaHub | Login</title>
    @vite(['resources/css/auth.css', 'resources/css/cursorTrail.css', 'resources/js/app.js'])
</head>

<body id="trail-stage">

    <div class="background-overlay" aria-hidden="true"></div>

    <main class="auth-page">

        <div class="auth-content">

            <header class="brand">
                <a href="/" aria-label="HexaHub Home">
                    <img src="{{ asset('images/hexahub.png') }}" alt="HexaHub" class="brand__logo">
                </a>
            </header>

            <section class="auth-section" aria-labelledby="login-title">

                <article class="auth-card">

                    <h1 id="login-title" class="sr-only">Log in to HexaHub</h1>

                    @if ($errors->any())
                        <p class="error-message">{{ $errors->first() }}</p>
                    @endif

                    <form class="auth-form" action="{{ route('login.submit') }}" method="POST">
                        @csrf

                        <fieldset class="auth-fields">

                            <legend class="sr-only">Login information</legend>

                            <!-- Email -->
                            <p class="form-field">
                                <label for="email">Email</label>
                                <span class="input-group">
                                    <span class="input-icon" aria-hidden="true">✉︎</span>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        autocomplete="email"
                                        placeholder="Enter your email"
                                        required
                                    >
                                </span>
                            </p>

                            <!-- Password -->
                            <p class="form-field">
                                <label for="password">Password</label>
                                <span class="input-group">
                                    <span class="input-icon" aria-hidden="true">🔒︎</span>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        autocomplete="current-password"
                                        placeholder="Enter your password"
                                        required
                                    >
                                </span>
                            </p>

                            <button type="submit" class="auth-button">Log In</button>

                        </fieldset>

                    </form>

                </article>

            </section>

            <footer class="site-footer">
                <p>Group 7</p>
            </footer>

        </div>

    </main>

</body>

</html>