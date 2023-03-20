<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all();
        $tags = Tag::all('id')->pluck('id')->toArray();

        foreach ($posts as $post) {
            $post->tags()->sync(Arr::random($tags, random_int(1, 3)));
        }
    }
}
