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
                'id_employee' => 'D001',
                'email' => 'dev@dev.com',
                'password' => env("DEV_PASSWORD"),
                'role' => 'developer',
            ],
            [
                'name' => 'Test Admin',
                'username' => 'admin',
                'id_employee' => 'A001',
                'email' => 'admin@admin.com',
                'password' => env("ADMIN_PASSWORD"),
                'role' => 'admin',
            ],
            [
                'name' => 'Test Op',
                'username' => 'op',
                'id_employee' => 'O001',
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
