<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HexaHub attendance logs">

    <title>HexaHub | Attendance Logs</title>

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
    </style>
</head>

<body id="trail-stage">

    <div class="dashboard-layout">

        @include('partials.sidebar')

        <main class="dashboard-content">

            <header class="dashboard-header">
                <div>
                    <p class="dashboard-label">HexaHub</p>
                    <h1>Attendance Logs</h1>
                </div>
            </header>

            <section class="dashboard-section" aria-labelledby="logs-heading">
                <article class="dashboard-card">

                    <header>
                        <h2 id="logs-heading">All Student Attendance</h2>
                    </header>

                    <form method="GET" action="{{ route('attendance.logs') }}">
                        <label for="date">Filter by date:</label>
                        <input type="date" name="date" id="date" value="{{ $date }}">
                        <button type="submit" class="time-button">Filter</button>
                        <a href="{{ route('attendance.logs') }}">Clear</a>
                    </form>

                    <div class="table-wrap">
                        <table class="log-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Student Number</th>
                                    <th>Name</th>
                                    <th>Year / Section</th>
                                    <th>College Program</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $log)
                                    <tr>
                                        <td>{{ $log->attendance_date }}</td>
                                        <td>{{ $log->student_number }}</td>
                                        <td>{{ $log->first_name }} {{ $log->last_name }}</td>
                                        <td>{{ $log->year_section }}</td>
                                        <td>{{ $log->college_program }}</td>
                                        <td>{{ $log->time_in }}</td>
                                        <td>{{ $log->time_out ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">No attendance records found.</td>
                                    </tr>
                                @endforelse
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