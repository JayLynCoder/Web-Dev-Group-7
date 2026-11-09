<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HexaHub | Manage Admins</title>
    @vite(['resources/css/record.css', 'resources/js/app.js'])
    <style>
        .dashboard-card, 
        .dashboard-card h2, 
        .dashboard-card label, 
        .dashboard-card table th, 
        .dashboard-card table td {
            color: #333333 !important;
        }
        .dashboard-card table th {
            font-weight: bold;
        }
        .action-buttons { display: flex; gap: 6px; align-items: center; }
        .edit-button {
            background: #2980b9; color: #fff; border: 0; padding: 5px 10px; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 13px; display: inline-block;
        }
        .delete-button {
            background: #c0392b; color: #fff; border: 0; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        @include('partials.sidebar')
        <main class="dashboard-content">
            <header class="dashboard-header">
                <h1 style="color: #333333;">Manage Administrators</h1>
            </header>

            <section class="dashboard-section">
                <!-- Create Admin Card -->
                <article class="dashboard-card">
                    <h2>Create New Admin</h2>

                    @if (session('status'))
                        <p class="status-message" style="color: green;">{{ session('status') }}</p>
                    @endif
                    @if ($errors->any())
                        <p class="error-message" style="color: red; margin-bottom: 10px;">{{ $errors->first() }}</p>
                    @endif

                    <form method="POST" action="{{ route('admin.store') }}">
                        @csrf
                        <div style="margin-bottom: 10px;">
                            <label>Name:</label>
                            <input type="text" name="name" value="{{ old('name') }}" required style="display:block; width:100%; padding:8px;">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label>Username:</label>
                            <input type="text" name="username" value="{{ old('username') }}" required style="display:block; width:100%; padding:8px;">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label>Email:</label>
                            <input type="email" name="email" value="{{ old('email') }}" required style="display:block; width:100%; padding:8px;">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label>Password:</label>
                            <input type="password" name="password" required style="display:block; width:100%; padding:8px;" placeholder="Min 8 chars, upper, lower, number, special">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label>Confirm Password:</label>
                            <input type="password" name="password_confirmation" required style="display:block; width:100%; padding:8px;">
                        </div>
                        <button type="submit" class="time-button" style="padding: 10px 15px; cursor: pointer;">Create Admin</button>
                    </form>
                </article>

                <!-- Existing Administrators Table -->
                <article class="dashboard-card" style="margin-top: 20px;">
                    <h2>Existing Administrators</h2>
                    <table style="width:100%; border-collapse: collapse; margin-top: 15px;">
                        <thead>
                            <tr style="border-bottom: 1px solid #ccc; text-align: left;">
                                <th style="padding: 8px;">ID</th>
                                <th style="padding: 8px;">Username</th>
                                <th style="padding: 8px;">Email</th>
                                <th style="padding: 8px;">Role</th>
                                <th style="padding: 8px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $adm)
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="padding: 8px;">{{ $adm->id }}</td>
                                    <td style="padding: 8px;">{{ $adm->username }}</td>
                                    <td style="padding: 8px;">{{ $adm->email }}</td>
                                    <td style="padding: 8px;">
                                        @if($adm->role === 'super_admin')
                                            Super Admin
                                        @elseif($adm->role === 'admin')
                                            Admin
                                        @else
                                            User
                                        @endif
                                    </td>
                                    <td style="padding: 8px;">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.edit', $adm->id) }}" class="edit-button">Edit</a>
                                            @if($adm->id === session('user_id') || $adm->email === session('email'))
                                                <em>(you)</em>
                                            @elseif($adm->role === 'super_admin')
                                                <span class="text-muted">-</span>
                                            @else
                                                <form action="{{ route('admin.destroy', $adm->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this admin?');" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-button">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </article>
            </section>
        </main>
    </div>
</body>
</html>