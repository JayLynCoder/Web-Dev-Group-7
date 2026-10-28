<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HexaHub user management">

    <title>HexaHub | Manage Users</title>

    @vite([
        'resources/css/record.css',
        'resources/js/app.js',
        'resources/css/cursorTrail.css'
    ])

    <style>
        .table-wrap { overflow-x: auto; }
        .log-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .log-table th,
        .log-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            color: #111 !important;
            background: transparent;
        }
        .log-table th { font-weight: 700; }
        .delete-button {
            background: #c0392b;
            color: #fff;
            border: 0;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        #create-heading { text-align: center; }

        /* Layout for the create-account form only */
        form.create-user-form {
            display: flex;
            flex-direction: column;
            gap: 4px;
            width: 100% !important;
            max-width: 340px !important;
            margin: 16px auto 0 !important;
        }
        form.create-user-form label {
            margin-top: 8px;
            font-weight: 600;
        }
        form.create-user-form input:not([type="checkbox"]),
        form.create-user-form select {
            width: 100% !important;
            padding: 8px 10px;
            box-sizing: border-box;
            border-radius: 6px;
        }
        form.create-user-form .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
            font-weight: 400;
        }
        form.create-user-form .checkbox-label input {
            width: auto !important;
        }
        form.create-user-form button {
            width: 100% !important;
            margin-top: 16px;
        }
    </style>
</head>

<body id="trail-stage">

    <div class="dashboard-layout">

        @include('partials.sidebar')

        <main class="dashboard-content">

            <header class="dashboard-header">
                <div>
                    <p class="dashboard-label">HexaHub</p>
                    <h1>Manage Users</h1>
                </div>
            </header>

            <section class="dashboard-section" aria-labelledby="create-heading">
                <article class="dashboard-card">

                    <header>
                        <h2 id="create-heading">Create User Account</h2>
                    </header>

                    @if (session('status'))
                        <p class="status-message">{{ session('status') }}</p>
                    @endif

                    @if ($errors->any())
                        <p class="error-message">{{ $errors->first() }}</p>
                    @endif

                    <form class="create-user-form" action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required>

                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" autocomplete="new-password" required>

                        <label for="password_confirmation">Confirm Password:</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" required>

                        <label for="student_id">Link to Student:</label>
                        <select name="student_id" id="student_id">
                            <option value="">-- None --</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                    {{ $student->student_number }} - {{ $student->first_name }} {{ $student->last_name }}
                                </option>
                            @endforeach
                        </select>

                        <label for="is_admin" class="checkbox-label">
                            <input type="checkbox" name="is_admin" id="is_admin" value="1" @checked(old('is_admin'))>
                            Admin account
                        </label>

                        <button type="submit" class="auth-button">Create Account</button>
                    </form>

                </article>
            </section>

            <section class="dashboard-section" aria-labelledby="users-heading">
                <article class="dashboard-card">

                    <header>
                        <h2 id="users-heading">Existing Accounts</h2>
                    </header>

                    <div class="table-wrap">
                        <table class="log-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->is_admin ? 'Admin' : 'Student' }}</td>
                                        <td>
                                            @if ($user->id !== session('user_id'))
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                      onsubmit="return confirm('Delete this account?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-button">Delete</button>
                                                </form>
                                            @else
                                                (you)
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </article>
            </section>

            <footer class="dashboard-footer">
                <p>&copy; {{ date('Y') }} HexaHub | Group 7</p>
            </footer>

        </main>

    </div>

</body>

</html>