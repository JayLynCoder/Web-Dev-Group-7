<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HexaHub | Edit User</title>
    <style>
        body { font-family: Arial, sans-serif; background: #111; color: #eee; margin: 0; padding: 2rem; }
        .card { max-width: 480px; margin: 0 auto; background: #1c1c1c; padding: 1.5rem; border-radius: 10px; }
        h1 { margin-top: 0; font-size: 1.4rem; }
        label { display: block; margin: 1rem 0 0.3rem; font-size: 0.9rem; }
        input, select { width: 100%; padding: 0.6rem; border-radius: 6px; border: 1px solid #444; background: #111; color: #eee; box-sizing: border-box; }
        .hint { font-size: 0.8rem; color: #999; margin-top: 0.3rem; }
        .errors { background: #4a1420; padding: 0.8rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .errors ul { margin: 0; padding-left: 1.2rem; }
        .actions { display: flex; gap: 0.8rem; margin-top: 1.5rem; }
        button, .cancel { padding: 0.6rem 1.2rem; border-radius: 6px; border: 0; cursor: pointer; font-size: 0.95rem; text-decoration: none; }
        button { background: #3b82f6; color: #fff; }
        .cancel { background: #333; color: #eee; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Edit account</h1>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>

            <label for="role">Role</label>
            @if ($user->role === 'superadmin')
                <input type="text" id="role" value="Super admin" disabled>
                <div class="hint">The super admin role can't be changed.</div>
            @else
                <select id="role" name="role" required>
                    <option value="student" @selected(old('role', $user->role) === 'student')>Student</option>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                </select>
            @endif

            <label for="student_id">Linked student</label>
            <select id="student_id" name="student_id">
                <option value="">None</option>
                @foreach ($students as $student)
                    <option value="{{ $student->student_number }}"
                        @selected((string) old('student_id', $user->student_id) === (string) $student->student_number)>
                        {{ $student->last_name }}, {{ $student->first_name }} ({{ $student->student_number }})
                    </option>
                @endforeach
            </select>

            <label for="password">New password</label>
            <input type="password" id="password" name="password" autocomplete="new-password">
            <div class="hint">Leave blank to keep the current password.</div>

            <label for="password_confirmation">Confirm new password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password">

            <div class="actions">
                <button type="submit">Save changes</button>
                <a class="cancel" href="{{ route('users.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>