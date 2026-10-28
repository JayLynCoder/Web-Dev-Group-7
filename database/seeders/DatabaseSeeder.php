<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Demo data so the app works right after `php artisan migrate --seed`.
 *
 *   Admin     admin@hexahub.test    / Admin@123
 *   Employee  employee@hexahub.test / Employee@123
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@hexahub.test'], [
            'username' => 'admin',
            'full_name' => 'HexaHub Admin',
            'password_hash' => password_hash('Admin@123', PASSWORD_BCRYPT),
            'is_admin' => true,
        ]);

        $employeeUser = User::updateOrCreate(['email' => 'employee@hexahub.test'], [
            'username' => 'HH-2026-001',
            'full_name' => 'Juan Dela Cruz',
            'password_hash' => password_hash('Employee@123', PASSWORD_BCRYPT),
            'is_admin' => false,
        ]);

        $juan = Employee::updateOrCreate(['employee_number' => 'HH-2026-001'], [
            'user_id' => $employeeUser->id,
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'department' => 'IT Department',
        ]);

        // A kiosk-only employee (no login account).
        Employee::updateOrCreate(['employee_number' => 'HH-2026-002'], [
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'department' => 'Human Resources',
        ]);

        // A few past days of attendance for Juan so the tables have data.
        $history = [
            [1, '08:57:00', '18:02:00'],
            [2, '09:03:00', '18:01:00'],
            [3, '08:49:00', '17:58:00'],
            [4, '09:12:00', '18:10:00'],
        ];

        foreach ($history as [$daysAgo, $in, $out]) {
            Attendance::updateOrCreate(
                ['employee_id' => $juan->id, 'attendance_date' => today()->subDays($daysAgo)],
                ['time_in' => $in, 'time_out' => $out],
            );
        }
    }
}
