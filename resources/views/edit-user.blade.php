<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Edit User Account in HexaHub">

    <title>HexaHub | Edit User Account</title>
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

            <section class="auth-section" aria-labelledby="edit-user-title">

                <article class="auth-card">

                    <h1 id="edit-user-title" class="sr-only">Edit User Account</h1>
                    
                    <div style="margin-bottom: 20px;">
                        <h2 style="font-size: 1.25rem; font-weight: bold; color: inherit;">Edit User Account</h2>
                    </div>

                    @if ($errors->any())
                        <p class="error-message">{{ $errors->first() }}</p>
                    @endif

                    @if (session('status'))
                        <p class="success-message" style="color: #51cf66; margin-bottom: 15px;">{{ session('status') }}</p>
                    @endif

                    <form class="auth-form" action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <fieldset class="auth-fields">

                            <legend class="sr-only">User modification information</legend>

                            <!-- Username -->
                            <p class="form-field">
                                <label for="username">Username</label>
                                <span class="input-group">
                                    <input
                                        type="text"
                                        id="username"
                                        name="username"
                                        value="{{ old('username', $user->username) }}"
                                        autocomplete="username"
                                        placeholder="Enter username"
                                        required
                                    >
                                </span>
                            </p>

                            <!-- Email -->
                            <p class="form-field">
                                <label for="email">Email</label>
                                <span class="input-group">
                                    <span class="input-icon" aria-hidden="true">✉︎</span>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', $user->email) }}"
                                        autocomplete="email"
                                        placeholder="Enter email"
                                        required
                                    >
                                </span>
                            </p>

                            <!-- Password -->
                            <p class="form-field">
                                <label for="password">New Password (leave blank to keep current)</label>
                                <span class="input-group">
                                    <span class="input-icon" aria-hidden="true">🔒︎</span>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        autocomplete="new-password"
                                        placeholder="Min 8 chars"
                                    >
                                </span>
                            </p>

                            <!-- Confirm Password -->
                            <p class="form-field">
                                <label for="password_confirmation">Confirm New Password</label>
                                <span class="input-group">
                                    <span class="input-icon" aria-hidden="true">🔒︎</span>
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        autocomplete="new-password"
                                        placeholder="Confirm password"
                                    >
                                </span>
                            </p>

                            <!-- Admin Account Checkbox (Side-by-side alignment) -->
                            <div class="form-field checkbox-group" style="display: flex; align-items: center; gap: 10px; margin: 15px 0;">
                                <input 
                                    type="checkbox" 
                                    id="is_admin" 
                                    name="is_admin" 
                                    value="1" 
                                    {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                                    style="width: 18px; height: 18px; cursor: pointer;"
                                >
                                <label for="is_admin" style="cursor: pointer; margin-bottom: 0;">Admin account</label>
                            </div>

                            <button type="submit" class="auth-button">Update Account</button>

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