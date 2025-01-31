<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Test Dev',
                'username' => 'dev',
                'email' => 'dev@dev.com',
                'password' => env("DEV_PASSWORD"),
                'role' => 'developer',
            ],
            [
                'name' => 'Test Admin',
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'password' => env("ADMIN_PASSWORD"),
                'role' => 'admin',
            ],
            [
                'name' => 'Test Op',
                'username' => 'op',
                'email' => 'op@op.com',
                'password' => env("OPERATOR_PASSWORD"),
                'role' => 'operator',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
