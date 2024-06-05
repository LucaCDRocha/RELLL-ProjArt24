<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 5; $i++) {
            $numbers = range(1, 3);
            shuffle($numbers);
            $n = rand(0, 3);

            for ($j = 0; $j < $n; $j++) {
                $user = User::find($numbers[$j]);
                $comment = Comment::find($i);

                Like::updateOrCreate([
                    'user_id' => $user->id,
                    'comment_id' => $comment->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
