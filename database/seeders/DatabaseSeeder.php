<?php

namespace Database\Seeders;

use App\Services\UserStore;
use Illuminate\Database\Seeder;
use Kreait\Firebase\Contract\Database;

/**
 * OPTIONAL demo data, written to FIREBASE (not MySQL).
 * Run with:  php artisan db:seed
 *
 * Safe to run more than once: it skips anything that already exists.
 * If your whole group shares one Firebase project, only run this once
 * (or not at all) so you don't fill the shared database with demo data.
 *
 *   Super admin  superadmin@hexahub.test / Admin@123
 *   Admin        admin@hexahub.test      / Admin@123
 *   Student      student@hexahub.test    / Student@123   (linked to 2023-00001)
 */
class DatabaseSeeder extends Seeder
{
    public function run(Database $database, UserStore $users): void
    {
        $students = [
            '2023-00001' => ['Juan', 'Dela Cruz', '3-1', 'BSIT'],
            '2023-00002' => ['Maria', 'Santos', '3-1', 'BSIT'],
        ];

        foreach ($students as $number => [$first, $last, $section, $program]) {
            $ref = $database->getReference("students/{$number}");

            if (! $ref->getSnapshot()->exists()) {
                $ref->set([
                    'first_name' => $first,
                    'last_name' => $last,
                    'student_number' => $number,
                    'year_section' => $section,
                    'college_program' => $program,
                    'picture' => '',
                ]);
            }
        }

        $accounts = [
            ['superadmin', 'superadmin@hexahub.test', 'Admin@123', 'superadmin', ''],
            ['admin', 'admin@hexahub.test', 'Admin@123', 'admin', ''],
            ['juan', 'student@hexahub.test', 'Student@123', 'student', '2023-00001'],
        ];

        foreach ($accounts as [$username, $email, $password, $role, $studentId]) {
            if ($users->emailExists($email)) {
                continue;
            }

            $users->create([
                'username' => $username,
                'full_name' => $studentId ? 'Juan Dela Cruz' : $username,
                'email' => $email,
                'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role,
                'student_id' => $studentId,
            ]);
        }

        $this->command?->info('Demo data added to Firebase.');
    }
}
