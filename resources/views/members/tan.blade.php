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
        content="HexaHub dashboard"
    >

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

                <h1 id="sidebar-title">
                    HexaHub
                </h1>

                <p>
                    Group 7
                </p>

            </header>


            <!-- Member List -->
            <nav
                class="sidebar-navigation"
                aria-labelledby="members-heading"
            >

                <h2 id="members-heading">
                    Members
                </h2>

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

                <form
                    action="/logout"
                    method="POST"
                >
                    @csrf

                    <button
                        type="submit"
                        class="auth-button logout-button"
                    >
                        Sign Out
                    </button>

                </form>

            </footer>

        </aside>


        <!-- Main Dashboard Content -->
        <main class="dashboard-content">

            <header class="dashboard-header">

                <div>

                    <p class="dashboard-label">
                        HexaHub
                    </p>

                    <h1>
                        Tan
                    </h1>

                </div>

            </header>


            <!-- Welcome Section -->
            <section
                class="dashboard-section"
                aria-labelledby="welcome-heading"
            >

                <article class="dashboard-card">

                    <header>

                        <h2 id="welcome-heading">
                            Welcome to HexaHub!
                        </h2>

                    </header>

                    <p>
                        Successfully logged in!
                    </p>

                    <p>
                        Welcome to the Group 7 dashboard.
                    </p>

                </article>

            </section>


            <!-- Group Section -->
            <section
                class="dashboard-section"
                aria-labelledby="group-heading"
            >

                <article class="dashboard-card">

                    <header>

                        <h2 id="group-heading">
                            Group 7
                        </h2>

                    </header>

                    <p>
                        This website was developed by the members of Group 7.
                    </p>

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