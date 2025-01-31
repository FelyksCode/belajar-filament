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
                'password' => '123',
                'role' => 'developer',
            ],
            [
                'name' => 'Test Admin',
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'password' => '123',
                'role' => 'admin',
            ],
            [
                'name' => 'Test Op',
                'username' => 'op',
                'email' => 'op@op.com',
                'password' => '123',
                'role' => 'operator',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
