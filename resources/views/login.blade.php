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


                    <form
                        class="auth-form"
                        action="#"
                        method="POST"
                    >

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
                                        autocomplete="email"
                                        placeholder="Enter your email"
                                        required
                                    >

                                </span>

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

                        <a href="/register">
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