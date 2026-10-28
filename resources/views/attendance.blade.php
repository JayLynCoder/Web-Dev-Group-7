<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HexaHub dashboard">

    <title>HexaHub | Record Attendance</title>

    @vite([
        'resources/css/record.css',
        'resources/js/app.js',
        'resources/css/cursorTrail.css'
    ])
</head>

<body id="trail-stage">

    <div class="dashboard-layout">

        @include('partials.sidebar')

        <main class="dashboard-content">

            <header class="dashboard-header">
                <div>
                    <p class="dashboard-label">HexaHub</p>
                    <h1>Record Student Attendance</h1>
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

                    @if (session('scanned_student'))
                        @php $student = session('scanned_student'); @endphp

                        <div class="employee-preview" id="student-preview">
                            <img
                                src="{{ asset('storage/students/' . $student->picture) }}"
                                alt="{{ $student->first_name }} {{ $student->last_name }}"
                                class="employee-photo"
                            >
                            <p>{{ $student->first_name }} {{ $student->last_name }}</p>
                            <p>{{ $student->year_section }}</p>
                            <p>{{ $student->college_program }}</p>
                        </div>

                        <script>
                            setTimeout(() => {
                                const preview = document.getElementById('student-preview');
                                if (preview) {
                                    preview.style.display = 'none';
                                }
                            }, 3000);
                        </script>
                    @endif

                    <form id="record-form" method="POST" action="{{ route('attendance.record') }}">
                        @csrf
                        <label for="studentId">Student Number:</label>
                        <input type="text" name="studentId" id="studentId" autofocus required>
                        <button type="submit" class="time-button">Submit</button>
                    </form>

                </article>
            </section>

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