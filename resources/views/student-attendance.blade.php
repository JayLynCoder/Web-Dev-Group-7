<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HexaHub | Student Attendance</title>
    @vite(['resources/css/auth.css', 'resources/css/cursorTrail.css', 'resources/js/app.js'])
</head>

<body id="trail-stage">
    <div class="background-overlay" aria-hidden="true"></div>

    <main class="auth-page" style="display: flex; min-height: 100vh;">

        <!-- Sidebar -->
        <nav style="width: 260px; background-color: #0b0f19; padding: 30px 20px; display: flex; flex-direction: column; justify-content: space-between; border-right: 1px solid rgba(255,255,255,0.05);">
            <div>
                <h2 style="color: #fff; font-size: 1.25rem; margin-bottom: 5px;">HexaHub</h2>
                <p style="color: #8a99ad; font-size: 0.85rem; margin-bottom: 40px;">Group 7</p>
                <p style="color: #8a99ad; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">Navigation</p>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li><a href="{{ route('student-attendance') }}" style="color: #60a5fa; text-decoration: none; font-size: 0.9rem;">Student Attendance</a></li>
                </ul>
            </div>
            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="width: 100%; padding: 10px; background: transparent; border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 4px; cursor: pointer;">Sign Out</button>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <div style="flex: 1; padding: 40px; overflow-y: auto;">
            <header style="margin-bottom: 30px;">
                <p style="text-transform: uppercase; font-size: 0.75rem; color: #8a99ad; letter-spacing: 1px;">Hexahub</p>
                <h1 style="font-size: 2rem; color: #111; font-weight: bold;">Student Attendance Portal</h1>
            </header>

            @if ($errors->any())
                <div style="background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div style="background: #dcfce7; color: #16a34a; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                    {{ session('status') }}
                </div>
            @endif

            <div style="background: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); padding: 30px; margin-bottom: 30px;">
                
                @if(isset($student) && $student)
                    <!-- Student Info & Action -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
                        <div>
                            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 5px; color: #111;">
                                {{ trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? '')) !== '' ? $student->first_name . ' ' . $student->last_name : 'Name Not Set' }}
                            </h2>
                            <p style="color: #666; font-size: 0.95rem; margin: 0;">
                                Student Number: <strong>{{ $student->student_number }}</strong> | 
                                Program: {{ $student->college_program ?? 'Not Set' }} | 
                                Section: {{ $student->year_section ?? 'Not Set' }}
                            </p>
                        </div>

                        <div>
                            <!-- 15-Minute Cooldown Timer Notice Alert -->
                            @if(isset($today) && $today && !$today->time_out)
                                <div style="font-size: 0.75rem; color: #d97706; background: #fffbeb; border: 1px solid #fde68a; padding: 6px 10px; border-radius: 4px; margin-bottom: 8px; text-align: center;">
                                    ⚠️ 15-min cooldown active between Time In & Time Out.
                                </div>
                            @endif

                            <form action="{{ route('student-attendance.record') }}" method="POST">
                                @csrf
                                <button type="submit" style="width: 100%; padding: 12px 24px; background-color: #2563eb; color: white; border: none; border-radius: 6px; font-weight: 500; cursor: pointer;">
                                    @if(!isset($today) || !$today)
                                        Time In
                                    @elseif(!$today->time_out)
                                        Time Out
                                    @else
                                        Attendance Completed
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- PROFILE EDIT FORM -->
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 25px; border-radius: 8px; margin-bottom: 30px;">
                        <h3 style="font-size: 1.15rem; margin-bottom: 15px; font-weight: bold; color: #1e293b;">Edit My Profile Information</h3>
                        <form action="{{ route('student.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                                <div>
                                    <label for="first_name" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #334155;">First Name:</label>
                                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $student->first_name) }}" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; color: #111;">
                                </div>
                                <div>
                                    <label for="last_name" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #334155;">Last Name:</label>
                                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $student->last_name) }}" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; color: #111;">
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                                <div>
                                    <label for="year_section" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #334155;">Year & Section:</label>
                                    <input type="text" id="year_section" name="year_section" value="{{ old('year_section', $student->year_section) }}" placeholder="e.g. 3rd Year - Section A" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; color: #111;">
                                </div>
                                <div>
                                    <label for="college_program" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; color: #334155;">College Program:</label>
                                    <input type="text" id="college_program" name="college_program" value="{{ old('college_program', $student->college_program) }}" placeholder="e.g. BS Information Technology" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; color: #111;">
                                </div>
                            </div>

                            <button type="submit" style="padding: 10px 24px; background-color: #0f172a; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Save Profile</button>
                        </form>
                    </div>

                @else
                    <div style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                        Your user account is not linked to any student record yet. Please contact an administrator.
                    </div>
                @endif

                <!-- Attendance History -->
                <div>
                    <h3 style="font-size: 1.1rem; margin-bottom: 15px; font-weight: bold; color: #111;">Attendance History</h3>
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; color: #111;">
                        <thead>
                            <tr style="border-bottom: 2px solid #eee; color: #333;">
                                <th style="padding: 10px;">Date</th>
                                <th style="padding: 10px;">Time In</th>
                                <th style="padding: 10px;">Time Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs ?? [] as $log)
                                <tr style="border-bottom: 1px solid #eee; color: #111;">
                                    <td style="padding: 10px; color: #111;">{{ $log->attendance_date }}</td>
                                    <td style="padding: 10px; color: #111;">{{ $log->time_in }}</td>
                                    <td style="padding: 10px; color: #111;">{{ $log->time_out ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center; padding: 20px; color: #666;">No attendance logs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>
</body>

</html>