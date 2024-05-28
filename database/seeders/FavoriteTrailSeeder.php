<?php

namespace Database\Seeders;

use App\Models\Favorite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteTrailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $favorite = Favorite::find(3);
        $favorite->trails()->attach(1);

        $favorite = Favorite::find(2);
        $favorite->trails()->attach(1);

        $favorite = Favorite::find(5);
        $favorite->trails()->attach(1);

        $favorite = Favorite::find(2);
        $favorite->trails()->attach(2);

        $favorite = Favorite::find(5);
        $favorite->trails()->attach(2);
    }
}
