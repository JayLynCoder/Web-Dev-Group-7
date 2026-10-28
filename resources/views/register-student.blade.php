<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HexaHub dashboard">

    <title>HexaHub | Register Student</title>

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
                    <h1>Register Student</h1>
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

                    <form id="register-form" action="{{ route('register-student.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <label for="fname">First Name:</label>
                        <input type="text" name="first_name" id="fname" value="{{ old('first_name') }}" required>

                        <label for="lname">Surname:</label>
                        <input type="text" name="last_name" id="lname" value="{{ old('last_name') }}" required>

                        <label for="student-number">Student Number:</label>
                        <input type="text" name="student_number" id="student-number" value="{{ old('student_number') }}" required>

                        <label for="year-section">Year / Section:</label>
                        <input type="text" name="year_section" id="year-section" value="{{ old('year_section') }}" placeholder="e.g. 3 / A" required>

                        <label for="college-program">College Program:</label>
                        <input type="text" name="college_program" id="college-program" value="{{ old('college_program') }}" placeholder="e.g. BSIT" required>

                        <label for="picture">Picture (JPEG only):</label>
                        <input type="file" name="picture" id="picture" accept="image/jpeg" required onchange="previewImage(event)">

                        <div id="preview-container" style="margin-top:10px;">
                            <img id="preview" src="" alt="Image preview" style="max-width:200px; display:none;">
                        </div>

                        <button type="submit" class="auth-button" id="register-button">Register Student</button>
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

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>

</body>

</html>