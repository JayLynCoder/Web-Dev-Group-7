<aside class="dashboard-sidebar" aria-labelledby="sidebar-title">

    <header class="sidebar-header">
        <h1 id="sidebar-title">HexaHub</h1>
        <p>Group 7</p>
    </header>

    <nav class="sidebar-navigation" aria-labelledby="nav-heading">

        <h2 id="nav-heading">Navigation</h2>

        <ul class="member-list">
            @if (session('is_admin'))
                <li class="member-item">
                    <a href="{{ route('attendance') }}" class="member-link">Record Attendance</a>
                </li>
                <li class="member-item">
                    <a href="{{ route('attendance.logs') }}" class="member-link">Attendance Logs</a>
                </li>
                <li class="member-item">
                    <a href="{{ route('register-student') }}" class="member-link">Register Student</a>
                </li>
                <li class="member-item">
                    <a href="{{ route('users.index') }}" class="member-link">Manage Users</a>
                </li>
            @else
                <li class="member-item">
                    <a href="{{ route('student-attendance') }}" class="member-link">Student Attendance</a>
                </li>
            @endif
        </ul>

    </nav>

    <footer class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="auth-button logout-button">Sign Out</button>
        </form>
    </footer>

</aside>