<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HexaHub | Register Student Number</title>
    @vite(['resources/css/record.css', 'resources/js/app.js'])
    <style>
        .dashboard-card { max-width: 500px; margin: 40px auto; padding: 25px; background: #fff; border-radius: 8px; color: #333 !important; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #333; }
        .form-group input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-primary { background: #2c3e50; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; width: 100%; }
    </style>
</head>
<body>
    <div class="dashboard-layout">
        @include('partials.sidebar')
        <main class="dashboard-content">
            <header class="dashboard-header">
                <h1 style="color: #333;">Register Student Number</h1>
            </header>

            <section class="dashboard-section">
                <article class="dashboard-card">
                    @if (session('status'))
                        <p style="color: green; margin-bottom: 15px;">{{ session('status') }}</p>
                    @endif
                    @if ($errors->any())
                        <p style="color: red; margin-bottom: 15px;">{{ $errors->first() }}</p>
                    @endif

                    <form action="{{ route('register-student.submit') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Student Number:</label>
                            <input type="text" name="student_number" value="{{ old('student_number') }}" required placeholder="Enter student number">
                        </div>
                        <button type="submit" class="btn-primary">Register Student Number</button>
                    </form>
                </article>
            </section>
        </main>
    </div>
</body>
</html>