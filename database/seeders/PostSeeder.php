<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all('id')->pluck('id')->toArray();
        $categories = Category::all('id')->pluck('id')->toArray();

        $numberPosts = 200;
        while ($numberPosts--) {
            Post::factory()->create([
                'author_id' => $users[array_rand($users)],
                'category_id' => $categories[array_rand($categories)],
            ]);
        }
    }
}
