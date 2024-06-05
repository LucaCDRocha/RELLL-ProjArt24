<?php
namespace Database\Seeders;

use App\Models\Favorite;
use Illuminate\Database\Seeder;

class FavoriteTrailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $favoritesAndTrails = [
            3 => [1],
            2 => [1, 2],
            5 => [1, 2],
        ];

        foreach ($favoritesAndTrails as $favoriteId => $trails) {
            $favorite = Favorite::find($favoriteId);
            if ($favorite) {
                $favorite->trails()->syncWithoutDetaching($trails);
            }
        }
    }
}
