<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::take(5)->get('id')->pluck('id');
        foreach ($posts as $postId) {
            Image::factory()->create([
                'imageable_id' => $postId,
                'imageable_type' => Post::class,
            ]);
        }

        $users = User::take(5)->get('id')->pluck('id');
        foreach ($users as $userId) {
            Image::factory()->create([
                'imageable_id' => $userId,
                'imageable_type' => User::class,
            ]);
        }
    }
}
