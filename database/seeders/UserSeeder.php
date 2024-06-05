<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            User::firstOrCreate(
                [
                    'email' => 'test@example.com',
                ],
                [
                    'name' => 'Test User',
                    'email_verified_at' => now(),
                    'password' => Hash::make("12345Test"),
                    'is_admin' => true
                ]
            );

            User::firstOrCreate(
                [
                    'email' => 'marc@example.com',
                ],
                [
                    'name' => 'Marc',
                    'email_verified_at' => now(),
                    'password' => Hash::make("12345Bob"),
                    'is_admin' => false
                ]
            );

            User::firstOrCreate(
                [
                    'email' => 'sam@example.com',
                ],
                [
                    'name' => 'Sam',
                    'email_verified_at' => now(),
                    'password' => Hash::make("yes1234"),
                    'is_admin' => true
                ]
            );
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
