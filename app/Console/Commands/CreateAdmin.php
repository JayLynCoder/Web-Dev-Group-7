<?php

namespace App\Console\Commands;

use App\Services\UserStore;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {username} {email} {password} {--role=admin : admin or superadmin}';

    protected $description = 'Create an admin or super admin account in Firebase';

    public function handle(UserStore $users): int
    {
        $username = $this->argument('username');
        $email    = $this->argument('email');
        $password = $this->argument('password');
        $role     = $this->option('role');

        if (! in_array($role, ['admin', 'superadmin'], true)) {
            $this->error("Role must be 'admin' or 'superadmin'.");
            return self::FAILURE;
        }

        if ($users->usernameExists($username)) {
            $this->error('That username is already taken.');
            return self::FAILURE;
        }

        if ($users->emailExists($email)) {
            $this->error('That email is already taken.');
            return self::FAILURE;
        }

        $users->create([
            'username'      => $username,
            'full_name'     => $username,
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role'          => $role,
            'student_id'    => '',
        ]);

        $this->info("{$role} account '{$username}' created.");

        return self::SUCCESS;
    }
}