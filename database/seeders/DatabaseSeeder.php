<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'spadmin@gmail.com'],
            [
                'username'      => 'SuperAdmin',
                'email'         => 'spadmin@gmail.com',
                'password_hash' => Hash::make('Admin123!'),
                'role'          => 'super_admin',
                'is_admin'      => 1,
            ]
        );
    }
}