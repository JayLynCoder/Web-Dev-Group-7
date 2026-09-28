<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="HexaHub dashboard">
    <title>HexaHub | Dashboard</title>
    @vite([
        'resources/css/member.css',
        'resources/js/app.js',
        'resources/css/cursorTrail.css'
    ])
</head>

<body id="trail-stage">
    <div class="dashboard-layout">
        <!-- Sidebar -->
        <aside
            class="dashboard-sidebar"
            aria-labelledby="sidebar-title"
        >
            <header class="sidebar-header">
                <h1 id="sidebar-title">HexaHub</h1>
                <p>Group 7</p>
            </header>


            <!-- Member List -->
            <nav
                class="sidebar-navigation"
                aria-labelledby="members-heading"
            >
                <h2 id="members-heading">Members</h2>
                <ul class="member-list">

                    @foreach ($members as $slug => $name)
                        <li class="member-item">
                            <a href="{{ route('members.show', $slug) }}" class="member-link">
                                <span class="member-icon" aria-hidden="true">●</span>
                                <span>{{ $name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <!-- Sidebar Footer -->
            <footer class="sidebar-footer">
                <form action="/logout"
                    method="POST">
                    @csrf

                    <button type="submit"
                        class="auth-button logout-button"
                    >Sign Out</button>
                </form>
            </footer>
        </aside>

        <!-- Main Dashboard Content -->
        <main class="dashboard-content">
            <header class="dashboard-header">
                <div>
                    <p class="dashboard-label">HexaHub</p>
                    <h1>Bernarte, Jaylee Johralyn C.</h1>
                </div>
            </header>


            <!-- Welcome Section -->
            <section class="dashboard-section"
                aria-labelledby="welcome-heading" >
                <article class="dashboard-card">
                    <header>
                        <h2 id="welcome-heading">Student Information</h2>
                    </header>
                    <p>Email: jayleebernarte@gmail.com</p>
                    <p>School Email: jayleejohralyncbernarte@iskolarngbayan.pup.edu.ph</p>
                    <p>Birthdate: July 11, 2006</p>
                    <p>University: Polytechnic University of the Philippines Santa Rosa Campus</p>
                    <p>Course: Bachelor of Science in Information Technology</p>
                    <p>Section: 3-1</p>
                </article>
            </section>


            <!-- Group Section -->
            <section
                class="dashboard-section"
                aria-labelledby="group-heading"
            >
                <article class="dashboard-card">
                    <header>
                        <h2 id="group-heading">Get To Know More</h2>
                    </header>
                    <p>Aspiration: Boboiboy Merch and Art Supplies</p>
                </article>
            </section>


            <footer class="dashboard-footer">
                <p>
                    &copy; {{ date('Y') }} HexaHub | Group 7
                </p>
            </footer>
        </main>
    </div>
</body>

</html>