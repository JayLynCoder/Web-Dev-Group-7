<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HexaHub dashboard">

    <title>HexaHub | Register Employee</title>

    @vite([
        'resources/css/record.css',
        'resources/js/app.js',
        'resources/css/cursorTrail.css'
    ])
</head>

<body id="trail-stage">

    <div class="dashboard-layout">

        <!-- Sidebar -->
        <aside class="dashboard-sidebar" aria-labelledby="sidebar-title">

            <header class="sidebar-header">
                <h1 id="sidebar-title">HexaHub</h1>
                <p>Group 7</p>
            </header>

            <nav class="sidebar-navigation" aria-labelledby="nav-heading">

                <h2 id="nav-heading">Navigation</h2>

                <ul class="member-list">
                    <li class="member-item">
                        <a href="{{ route('attendance') }}" class="member-link">Record Attendance</a>
                    </li>

                    @if (session('is_admin'))
                        <li class="member-item">
                            <a href="{{ route('register-employee') }}" class="member-link">Register Employee</a>
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

        <!-- Main Content -->
        <main class="dashboard-content">

            <header class="dashboard-header">
                <div>
                    <p class="dashboard-label">HexaHub</p>
                    <h1>Register Employee</h1>
                </div>
            </header>

            <section class="dashboard-section" aria-labelledby="welcome-heading">
                <article class="dashboard-card">

                    <header>
                        <h2 id="welcome-heading">Welcome to HexaHub!</h2>
                    </header>

                    @if (session('status'))
                        <p class="status-message">{{ session('status') }}</p>
                    @endif

                    @if ($errors->any())
                        <p class="error-message">{{ $errors->first() }}</p>
                    @endif

                    <form action="{{ route('register-employee.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <label for="fname">First Name:</label>
                        <input type="text" name="first_name" id="fname" value="{{ old('first_name') }}" required>

                        <label for="lname">Last Name:</label>
                        <input type="text" name="last_name" id="lname" value="{{ old('last_name') }}" required>

                        <label for="employee-number">Employee Number:</label>
                        <input type="text" name="employee_number" id="employee-number" value="{{ old('employee_number') }}" required>

                        <label for="department">Department:</label>
                        <input type="text" name="department" id="department" value="{{ old('department') }}" required>

                        <label for="picture">Picture:</label>
                        <input type="file" name="picture" id="picture" accept="image/*" required>

                        <button type="submit" class="auth-button">Register Employee</button>
                    </form>

                </article>
            </section>

            <!-- Group Section -->
            <section class="dashboard-section" aria-labelledby="group-heading">
                <article class="dashboard-card">
                    <header>
                        <h2 id="group-heading">Group 7</h2>
                    </header>
                    <p>This website was developed by the members of Group 7.</p>
                </article>
            </section>

            <footer class="dashboard-footer">
                <p>&copy; {{ date('Y') }} HexaHub | Group 7</p>
            </footer>

        </main>

    </div>

</body>

</html>