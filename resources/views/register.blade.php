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
        content="Create a HexaHub account"
    >

    <title>HexaHub | Register</title>
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


            <!-- Registration section -->
            <section
                class="auth-section"
                aria-labelledby="register-title"
            >

                <article class="auth-card">

                    <h1
                        id="register-title"
                        class="sr-only"
                    >
                        Create a HexaHub account
                    </h1>


                    <form
                        class="auth-form"
                        action="#"
                        method="POST"
                    >

                        <fieldset class="auth-fields">

                            <legend class="sr-only">
                                Registration information
                            </legend>


                            <!-- Username -->
                            <p class="form-field">

                                <label for="username">
                                    Username
                                </label>

                                <span class="input-group">

                                    <span
                                        class="input-icon"
                                        aria-hidden="true"
                                    >
                                        ★
                                    </span>

                                    <input
                                        type="text"
                                        id="username"
                                        name="username"
                                        autocomplete="username"
                                        placeholder="Choose a username"
                                        required
                                    >

                                </span>

                            </p>


                            <!-- Email -->
                            <p class="form-field">

                                <label for="register-email">
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
                                        id="register-email"
                                        name="email"
                                        autocomplete="email"
                                        placeholder="Enter your email"
                                        required
                                    >

                                </span>

                            </p>


                            <!-- Password -->
                            <p class="form-field">

                                <label for="register-password">
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
                                        id="register-password"
                                        name="password"
                                        autocomplete="new-password"
                                        placeholder="Create a password"
                                        required
                                    >

                                </span>

                            </p>


                            <!-- Register button -->
                            <button
                                type="submit"
                                class="auth-button"
                            >
                                Register
                            </button>

                        </fieldset>

                    </form>


                    <!-- Login link -->
                    <p class="account-switch">

                        Already have an account?

                        <a href="/login">
                            Log in here
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