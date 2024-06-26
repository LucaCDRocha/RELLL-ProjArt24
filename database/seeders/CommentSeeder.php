<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\JsonHelper;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $data = JsonHelper::readJson('/interactionsTest.json'); //récupère des infos dans le JSON
            $comments = collect($data['comments']);

            foreach ($comments as $comment) {
                $trailId = JsonHelper::getInfoByValue('trails', 'name', $comment['trail']);
                $userId = JsonHelper::getInfoByValue('users', 'name', $comment['user']);

                $date = date("2024-06-10 00:00:00");

                Comment::updateOrCreate([
                    'text' => $comment['content'],
                    'trail_id' => $trailId,
                    'user_id' => $userId,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
