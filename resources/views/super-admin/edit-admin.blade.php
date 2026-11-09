<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HexaHub | Edit Administrator</title>
    @vite(['resources/css/record.css', 'resources/js/app.js'])
    <style>
        .dashboard-card { max-width: 500px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 8px; color: #333 !important; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #333; }
        .form-group input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-primary { background: #2c3e50; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; width: 100%; }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        @include('partials.sidebar')
        <main class="dashboard-content">
            <header class="dashboard-header">
                <h1>Edit Administrator</h1>
            </header>
            <section class="dashboard-section">
                <article class="dashboard-card">
                    @if ($errors->any())
                        <p style="color: red; margin-bottom: 10px;">{{ $errors->first() }}</p>
                    @endif
                    <form action="{{ route('admin.update', $admin->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" name="name" value="{{ old('name', $admin->full_name) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" name="username" value="{{ old('username', $admin->username) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label>New Password (leave blank to keep current):</label>
                            <input type="password" name="password" placeholder="Min 8 chars">
                        </div>
                        <div class="form-group">
                            <label>Confirm New Password:</label>
                            <input type="password" name="password_confirmation">
                        </div>
                        <button type="submit" class="btn-primary">Update Admin</button>
                    </form>
                </article>
            </section>
        </main>
    </div>
</body>
</html>