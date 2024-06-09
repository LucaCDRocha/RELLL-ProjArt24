<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //liste de base pour tous les utilisateurs
        for ($i = 1; $i < 4; $i++) {
            Favorite::updateOrCreate([
                'user_id' => $i,
                'name' => 'favoris',
            ]);
        }
        
        //listes spéciales pour un utilisateur
        $listes = ["A faire avec ma famille", "A refaire", "Why not"];
        for ($i=0; $i < count($listes); $i++) { 
            Favorite::updateOrCreate([
                'user_id' => 2,
                'name' => $listes[$i],
            ],[
                'user_id' => 2,
                'name' => $listes[$i],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
