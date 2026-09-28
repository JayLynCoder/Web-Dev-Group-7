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

    @vite([
        'resources/css/auth.css',
        'resources/css/cursorTrail.css',
        'resources/js/app.js'
    ])
</head>

<body id="trail-stage">

    <div
        class="background-overlay"
        aria-hidden="true"
    ></div>


    <main class="auth-page">

        <div class="auth-content">

            <!-- Brand -->
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


            <!-- Registration -->
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


                    <!-- Validation Errors -->
                    @if ($errors->any())

                        <aside
                            class="form-errors"
                            role="alert"
                            aria-labelledby="error-title"
                        >

                            <h2
                                id="error-title"
                                class="sr-only"
                            >
                                Registration errors
                            </h2>

                            <ul>

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </aside>

                    @endif


                    <form
                        class="auth-form"
                        action="/register"
                        method="POST"
                        id="register-form"
                    >

                        @csrf


                        <fieldset class="auth-fields">

                            <legend class="sr-only">
                                Registration information
                            </legend>


                            <!-- Username -->
                            <div class="form-field">

                                <label for="username">
                                    Username
                                </label>

                                <div class="input-group">

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
                                        value="{{ old('username') }}"
                                        autocomplete="username"
                                        placeholder="Choose a username"
                                        required
                                    >

                                </div>

                            </div>


                            <!-- Email -->
                            <div class="form-field">

                                <label for="register-email">
                                    Email
                                </label>

                                <div class="input-group">

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
                                        value="{{ old('email') }}"
                                        autocomplete="email"
                                        placeholder="Enter your email"
                                        required
                                    >

                                </div>

                            </div>


                            <!-- Password -->
                            <div class="form-field">

                                <label for="register-password">
                                    Password
                                </label>

                                <div class="input-group">

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
                                        aria-describedby="password-requirements"
                                        required
                                    >

                                </div>

                            </div>


                            <!-- Confirm Password -->
                            <div class="form-field">

                                <label for="password-confirmation">
                                    Confirm Password
                                </label>

                                <div class="input-group">

                                    <span
                                        class="input-icon"
                                        aria-hidden="true"
                                    >
                                        🔒︎
                                    </span>

                                    <input
                                        type="password"
                                        id="password-confirmation"
                                        name="password_confirmation"
                                        autocomplete="new-password"
                                        placeholder="Confirm your password"
                                        required
                                    >

                                </div>

                                <small
                                    id="password-match"
                                    class="password-match"
                                    aria-live="polite"
                                ></small>

                            </div>


                            <!-- Password Requirements -->
                            <section
                                id="password-requirements"
                                class="password-requirements"
                                aria-labelledby="password-requirements-title"
                            >

                                <h2 id="password-requirements-title">
                                    Password requirements
                                </h2>

                                <ul>

                                    <li id="requirement-length">
                                        <span
                                            class="requirement-icon"
                                            aria-hidden="true"
                                        >
                                            ○
                                        </span>

                                        At least 8 characters
                                    </li>

                                    <li id="requirement-uppercase">
                                        <span
                                            class="requirement-icon"
                                            aria-hidden="true"
                                        >
                                            ○
                                        </span>

                                        At least 1 uppercase letter
                                    </li>

                                    <li id="requirement-lowercase">
                                        <span
                                            class="requirement-icon"
                                            aria-hidden="true"
                                        >
                                            ○
                                        </span>

                                        At least 1 lowercase letter
                                    </li>

                                    <li id="requirement-number">
                                        <span
                                            class="requirement-icon"
                                            aria-hidden="true"
                                        >
                                            ○
                                        </span>

                                        At least 1 number
                                    </li>

                                    <li id="requirement-special">
                                        <span
                                            class="requirement-icon"
                                            aria-hidden="true"
                                        >
                                            ○
                                        </span>

                                        At least 1 special character
                                    </li>

                                </ul>

                            </section>


                            <!-- Register Button -->
                            <button
                                type="submit"
                                class="auth-button"
                                id="register-button"
                            >
                                Register
                            </button>

                        </fieldset>

                    </form>


                    <!-- Login -->
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


    <!-- Registration Success Dialog -->
    @if (session('registration_success'))

        <dialog
            id="registration-success"
            class="success-dialog"
            aria-labelledby="success-title"
        >

            <article class="success-dialog__content">

                <div
                    class="success-dialog__icon"
                    aria-hidden="true"
                >
                    ✓
                </div>

                <h2 id="success-title">
                    Registration Successful!
                </h2>

                <p>
                    Your HexaHub account has been created successfully.
                    You can now sign in using your account.
                </p>

                <a
                    href="/login"
                    class="success-dialog__button"
                >
                    Sign In
                </a>

            </article>

        </dialog>

    @endif


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const password =
                document.getElementById('register-password');

            const confirmation =
                document.getElementById('password-confirmation');

            const passwordMatch =
                document.getElementById('password-match');


            const requirements = {

                length: {
                    element:
                        document.getElementById('requirement-length'),

                    test: value => value.length >= 8
                },

                uppercase: {
                    element:
                        document.getElementById('requirement-uppercase'),

                    test: value => /[A-Z]/.test(value)
                },

                lowercase: {
                    element:
                        document.getElementById('requirement-lowercase'),

                    test: value => /[a-z]/.test(value)
                },

                number: {
                    element:
                        document.getElementById('requirement-number'),

                    test: value => /[0-9]/.test(value)
                },

                special: {
                    element:
                        document.getElementById('requirement-special'),

                    test: value =>
                        /[!@#$%^&*(),.?":{}|<>_\-+=]/.test(value)
                }

            };


            function updateRequirement(requirement, passed) {

                const icon =
                    requirement.element.querySelector(
                        '.requirement-icon'
                    );

                if (passed) {

                    requirement.element.classList.add(
                        'requirement-valid'
                    );

                    icon.textContent = '✓';

                } else {

                    requirement.element.classList.remove(
                        'requirement-valid'
                    );

                    icon.textContent = '○';

                }

            }


            function checkPassword() {

                const value = password.value;

                Object.values(requirements).forEach(
                    requirement => {

                        updateRequirement(
                            requirement,
                            requirement.test(value)
                        );

                    }
                );

                checkPasswordMatch();
            }


            function checkPasswordMatch() {

                if (confirmation.value === '') {

                    passwordMatch.textContent = '';

                    passwordMatch.classList.remove(
                        'match-valid',
                        'match-invalid'
                    );

                    return;
                }


                if (
                    password.value === confirmation.value
                ) {

                    passwordMatch.textContent =
                        '✓ Passwords match';

                    passwordMatch.classList.add(
                        'match-valid'
                    );

                    passwordMatch.classList.remove(
                        'match-invalid'
                    );

                } else {

                    passwordMatch.textContent =
                        '✕ Passwords do not match';

                    passwordMatch.classList.add(
                        'match-invalid'
                    );

                    passwordMatch.classList.remove(
                        'match-valid'
                    );

                }

            }


            password.addEventListener(
                'input',
                checkPassword
            );

            confirmation.addEventListener(
                'input',
                checkPasswordMatch
            );


            // Open registration success popup
            const successDialog =
                document.getElementById(
                    'registration-success'
                );

            if (successDialog) {

                successDialog.showModal();

            }

        });
    </script>

</body>

</html>