<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\JsonHelper;

class ThemesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $data = JsonHelper::readJson('/jeuTest.json'); //récupère des infos dans jeuTest.json

            $themes = collect($data['themes'])
                ->values()
                ->all();

                foreach ($themes as $theme) {
                    Theme::create([
                        'name' => $theme['name'],
                        'description' => $theme['descr']
                    ]);
                }

        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}