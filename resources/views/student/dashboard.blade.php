<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>HexaHub | Employee Portal</title>

    @vite([
        'resources/css/employee.css',
        'resources/js/employee.js'
    ])

</head>

<body>

    <!-- BACKGROUND VIDEO -->

    <video
        class="employee-background"
        autoplay
        muted
        loop
        playsinline
    >
        <source
            src="{{ asset('videos/background.mp4') }}"
            type="video/mp4"
        >
    </video>


    <div class="employee-overlay"></div>


    <!-- EMPLOYEE APPLICATION -->

    <div class="employee-app">

        <!-- SIDEBAR -->

        <aside class="employee-sidebar">

            <div class="employee-brand">

                <a href="/employee">

                    <img
                        src="{{ asset('images/hexahub.png') }}"
                        alt="HexaHub"
                    >

                </a>

            </div>


            <p class="employee-portal-label">
                Employee Portal
            </p>


            <nav class="employee-navigation">

                <a
                    href="/employee"
                    class="employee-nav-link active"
                >
                    <span class="employee-nav-icon">
                        ▣
                    </span>

                    Dashboard
                </a>


                <a
                    href="/employee/attendance"
                    class="employee-nav-link"
                >
                    <span class="employee-nav-icon">
                        ◷
                    </span>

                    My Attendance
                </a>


                <a
                    href="/employee/profile"
                    class="employee-nav-link"
                >
                    <span class="employee-nav-icon">
                        ◉
                    </span>

                    Profile
                </a>

            </nav>


            <div class="employee-sidebar-bottom">

                <button
                    class="employee-logout"
                    id="logoutButton"
                >
                    ↪ &nbsp; Sign Out
                </button>

            </div>

        </aside>


        <!-- MAIN -->

        <main class="employee-main">

            <!-- TOP BAR -->

            <header class="employee-topbar">

                <div class="employee-topbar-title">

                    <button
                        class="employee-mobile-button"
                        id="mobileMenuButton"
                    >
                        ☰
                    </button>

                    <p>
                        Employee Portal
                    </p>

                    <h1>
                        Dashboard
                    </h1>

                </div>


                <div class="employee-user">

                    <div class="employee-avatar">
                        JD
                    </div>

                    <div class="employee-user-info">

                        <strong>
                            Juan Dela Cruz
                        </strong>

                        <span>
                            HH-2026-001
                        </span>

                    </div>

                </div>

            </header>


            <!-- WELCOME -->

            <section class="employee-welcome">

                <p class="eyebrow">
                    TODAY'S ATTENDANCE
                </p>

                <h2>
                    Good morning, Juan.
                </h2>

                <p>
                    Manage your attendance and work session.
                </p>

            </section>


            <!-- EMPLOYEE INFORMATION -->

            <section class="employee-card employee-info">

                <div class="employee-info-left">

                    <div class="employee-large-avatar">
                        JD
                    </div>

                    <div>

                        <h3>
                            Juan Dela Cruz
                        </h3>

                        <p>
                            Employee No. HH-2026-001
                        </p>

                        <p>
                            IT Department
                        </p>

                    </div>

                </div>


                <div class="employee-status">

                    <span class="employee-status-label">
                        Current Status
                    </span>

                    <div class="employee-status-value">

                        <span
                            class="employee-status-dot"
                            id="statusDot"
                        ></span>

                        <span id="statusText">
                            Not Clocked In
                        </span>

                    </div>

                </div>

            </section>


            <!-- ATTENDANCE + SCHEDULE -->

            <section class="attendance-layout">


                <!-- ATTENDANCE -->

                <div class="employee-card attendance-card">

                    <p class="eyebrow">
                        ATTENDANCE
                    </p>

                    <h2>
                        Today's Work Session
                    </h2>


                    <div class="employee-clock">

                        <span class="employee-clock-label">
                            CURRENT TIME
                        </span>

                        <strong
                            class="employee-clock-time"
                            id="liveClock"
                        >
                            00:00:00
                        </strong>

                        <span
                            class="employee-clock-date"
                            id="clockDate"
                        >
                            October 8, 2026
                        </span>

                    </div>


                    <div class="attendance-times">

                        <div class="attendance-time">

                            <span>
                                Clock In
                            </span>

                            <strong id="clockInTime">
                                —
                            </strong>

                        </div>


                        <div
                            class="attendance-time-divider"
                        ></div>


                        <div class="attendance-time">

                            <span>
                                Clock Out
                            </span>

                            <strong id="clockOutTime">
                                —
                            </strong>

                        </div>

                    </div>


                    <button
                        class="employee-action"
                        id="attendanceAction"
                    >
                        Clock In
                    </button>


                    <p
                        class="employee-action-note"
                        id="actionNote"
                    >
                        Start your work session for today.
                    </p>

                </div>


                <!-- SCHEDULE -->

                <div class="employee-card schedule-card">

                    <div class="schedule-header">

                        <div>

                            <p class="eyebrow">
                                TODAY
                            </p>

                            <h2>
                                Work Schedule
                            </h2>

                        </div>

                        <span class="schedule-badge">
                            REGULAR
                        </span>

                    </div>


                    <div class="schedule-hours">

                        <div class="schedule-time-box">

                            <span>
                                START
                            </span>

                            <strong>
                                9:00 AM
                            </strong>

                        </div>


                        <div class="schedule-line"></div>


                        <div class="schedule-time-box">

                            <span>
                                END
                            </span>

                            <strong>
                                6:00 PM
                            </strong>

                        </div>

                    </div>


                    <div class="schedule-detail">

                        <span>
                            Break
                        </span>

                        <strong>
                            1 hour
                        </strong>

                    </div>


                    <div class="schedule-detail">

                        <span>
                            Expected Hours
                        </span>

                        <strong>
                            8 hours
                        </strong>

                    </div>

                </div>

            </section>


            <!-- RECENT ATTENDANCE -->

            <section class="employee-card activity-card">

                <div class="activity-header">

                    <div>

                        <p class="eyebrow">
                            ACTIVITY
                        </p>

                        <h2>
                            Recent Attendance
                        </h2>

                    </div>

                    <a
                        href="/employee/attendance"
                        class="activity-link"
                    >
                        View All →
                    </a>

                </div>


                <div class="activity-table">

                    <div class="activity-table-header">

                        <span>Date</span>
                        <span>Clock In</span>
                        <span>Clock Out</span>
                        <span>Total</span>
                        <span>Status</span>

                    </div>


                    <div class="activity-table-row">

                        <span>
                            October 7, 2026
                        </span>

                        <span>
                            8:57 AM
                        </span>

                        <span>
                            6:02 PM
                        </span>

                        <span>
                            8h 05m
                        </span>

                        <span class="activity-status present">
                            PRESENT
                        </span>

                    </div>


                    <div class="activity-table-row">

                        <span>
                            October 6, 2026
                        </span>

                        <span>
                            9:03 AM
                        </span>

                        <span>
                            6:01 PM
                        </span>

                        <span>
                            7h 58m
                        </span>

                        <span class="activity-status late">
                            LATE
                        </span>

                    </div>

                </div>

            </section>

        </main>

    </div>


    <!-- CONFIRMATION MODAL -->

    <div
        class="employee-modal-overlay"
        id="confirmationModal"
    >

        <div class="employee-modal">

            <div class="employee-modal-icon">
                ◷
            </div>

            <h2 id="modalTitle">
                Confirm Clock In
            </h2>

            <p id="modalDescription">
                Are you sure you want to clock in
                and start your work session?
            </p>


            <div class="employee-confirmation-details">

                <div class="employee-confirmation-row">

                    <span>
                        Employee
                    </span>

                    <strong>
                        Juan Dela Cruz
                    </strong>

                </div>


                <div class="employee-confirmation-row">

                    <span>
                        Date
                    </span>

                    <strong id="modalDate">
                        —
                    </strong>

                </div>


                <div class="employee-confirmation-row">

                    <span>
                        Time
                    </span>

                    <strong id="modalTime">
                        —
                    </strong>

                </div>

            </div>


            <div class="employee-modal-actions">

                <button
                    class="employee-modal-cancel"
                    id="cancelModal"
                >
                    Cancel
                </button>

                <button
                    class="employee-modal-confirm"
                    id="confirmAttendance"
                >
                    Confirm Clock In
                </button>

            </div>

        </div>

    </div>


    <!-- SUCCESS -->

    <div
        class="employee-modal-overlay"
        id="successModal"
    >

        <div class="employee-modal employee-success">

            <div class="employee-success-icon">
                ✓
            </div>

            <h2 id="successTitle">
                Clock In Successful
            </h2>

            <p id="successMessage">
                Your work session has started.
            </p>

            <strong
                class="employee-success-time"
                id="successTime"
            >
                9:00 AM
            </strong>

            <div
                class="employee-success-progress"
            ></div>

        </div>

    </div>


    <script>
        window.employeeData = {
            name: "Juan Dela Cruz",
            employeeNumber: "HH-2026-001",
            department: "IT Department"
        };
    </script>

</body>

</html>