<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HexaHub user management">
    <title>HexaHub | Manage Users</title>
    @vite(['resources/css/record.css', 'resources/js/app.js', 'resources/css/cursorTrail.css'])
    <style>
        .table-wrap { overflow-x: auto; }
        .log-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .log-table th, .log-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            color: #111 !important;
            background: transparent;
        }
        .log-table th { font-weight: 700; }
        .action-buttons { display: flex; gap: 6px; align-items: center; }
        .edit-button {
            background: #2980b9; color: #fff; border: 0; padding: 6px 12px; border-radius: 6px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 13px;
        }
        .delete-button {
            background: #c0392b; color: #fff; border: 0; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 13px;
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

            @if (session('status'))
                <p class="status-message" style="color: green; margin-bottom: 15px;">{{ session('status') }}</p>
            @endif
            @if ($errors->any())
                <p class="error-message" style="color: red; margin-bottom: 15px;">{{ $errors->first() }}</p>
            @endif

            <!-- Existing Accounts Table Moved to Top -->
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
                                        <td>
                                            @if($user->role === 'super_admin')
                                                Super Admin
                                            @elseif($user->role === 'admin' || $user->is_admin)
                                                Admin
                                            @else
                                                User
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route(Route::has('users.edit') ? 'users.edit' : 'admin.edit', $user->id) }}" class="edit-button">Edit</a>
                                                @if ($user->id !== session('user_id'))
                                                    @if (!($user->role === 'super_admin' || ($user->role === 'admin' && session('role') !== 'super_admin')))
                                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this account?');" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="delete-button">Delete</button>
                                                        </form>
                                                    @endif
                                                @else
                                                    <em>(you)</em>
                                                @endif
                                            </div>
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