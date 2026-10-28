<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HexaHub student attendance">

    <title>HexaHub | Student Attendance</title>

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
        .record-box { margin: 16px 0; }
        .time-button:disabled { opacity: 0.6; cursor: not-allowed; }
    </style>
</head>

<body id="trail-stage">

    <div class="dashboard-layout">

        @include('partials.sidebar')

        <main class="dashboard-content">

            <header class="dashboard-header">
                <div>
                    <p class="dashboard-label">HexaHub</p>
                    <h1>Student Attendance</h1>
                </div>
            </header>

            <section class="dashboard-section" aria-labelledby="student-logs-heading">
                <article class="dashboard-card">

                    <header>
                        <h2 id="student-logs-heading">
                            @if ($student)
                                {{ $student->first_name }} {{ $student->last_name }}
                                ({{ $student->student_number }})
                            @else
                                Student Attendance Logs
                            @endif
                        </h2>
                    </header>

                    @if (session('status'))
                        <p class="status-message">{{ session('status') }}</p>
                    @endif

                    @if ($errors->any())
                        <p class="error-message">{{ $errors->first() }}</p>
                    @endif

                    @if (! $student)
                        <p class="error-message">
                            Your account is not linked to a student record yet. Please ask an admin to link it.
                        </p>
                    @else
                        <div class="record-box">
                            @if (! $today)
                                <form method="POST" action="{{ route('student-attendance.record') }}">
                                    @csrf
                                    <button type="submit" class="time-button">Time In</button>
                                </form>
                            @elseif (! $today->time_out)
                                <form method="POST" action="{{ route('student-attendance.record') }}">
                                    @csrf
                                    <button type="submit" class="time-button">Time Out</button>
                                </form>
                            @else
                                <button type="button" class="time-button" disabled>
                                    Attendance completed for today
                                </button>
                            @endif
                        </div>

                        <div class="table-wrap">
                            <table class="log-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($logs as $log)
                                        <tr>
                                            <td>{{ $log->attendance_date }}</td>
                                            <td>{{ $log->time_in }}</td>
                                            <td>{{ $log->time_out ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">No attendance records yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif

                </article>
            </section>

            <footer class="dashboard-footer">
                <p>&copy; {{ date('Y') }} HexaHub | Group 7</p>
            </footer>

        </main>

    </div>

</body>

</html>