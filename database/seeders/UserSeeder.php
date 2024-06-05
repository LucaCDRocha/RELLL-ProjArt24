<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            User::firstOrCreate([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make("12345Test"),
                'is_admin' => true
            ]);
            User::firstOrCreate([
                'name' => 'Marc',
                'email' => 'marc@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make("12345Bob"),
                'is_admin' => false
            ]);
            User::firstOrCreate([
                'name' => 'Sam',
                'email' => 'sam@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make("yes1234"),
                'is_admin' => true
            ]);
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
