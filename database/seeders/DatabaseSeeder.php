<?php

namespace Database\Seeders;

use App\Models\InterestPoint;
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

        // création d'utilisateurs tests
        $this->call(UserSeeder::class);

        // création des parcours tests
        $this->call(TagSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(InterestPointSeeder::class);
        $this->call(ImgSeeder::class);
        $this->call(TrailsSeeder::class);
        $this->call(InterestPointTrailSeeder::class);
        $this->call(InterestPointTagSeeder::class);

        // création de commentaires et de notes test
        // $this->call(CommentSeeder::class);
        // $this->call(LikeSeeder::class);
        // $this->call(RankingSeeder::class);

        // création de favoris et de listes
        $this->call(FavoriteSeeder::class);
        $this->call(FavoriteTrailSeeder::class);

        // création de l'historique
        $this->call(HistoricSeeder::class);
    }
}
