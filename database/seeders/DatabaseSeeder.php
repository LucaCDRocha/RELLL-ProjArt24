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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //création des parcours tests
       // $this->call(TagSeeder::class);
       // $this->call(LocationSeeder::class);
         $this->call(ThemesSeeder::class);
        // $this->call(InterestPointSeeder::class);
        // $this->call(ImgSeeder::class);
        // $this->call(TrailsSeeder::class);
        // $this->call(InterestPointTrailSeeder::class);
        // $this->call(ThemeTrailSeeder::class);
    }
}
