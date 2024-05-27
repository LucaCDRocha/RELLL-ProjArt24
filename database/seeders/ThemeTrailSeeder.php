<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\JsonHelper;
use App\Models\Trail;
use App\Models\Theme;

class ThemeTrailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $data = JsonHelper::readJson('/jeuTest.json'); //récupère des infos dans jeuTest.json
            $trails = collect($data['sentiers']);

            foreach ($trails as $trail) {

                $trailId = JsonHelper::getInfoByValue('trails', 'name', $trail['titre']);
                $trailDatas = Trail::find($trailId);
                $themes = $trail['themes'];

                for ($i = 0; $i < count($themes); $i++) {
                    $themeId = JsonHelper::getInfoByValue('themes', 'name', $themes[$i]);

                    $trailDatas->themes()->attach($themeId);
                }
            }
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
