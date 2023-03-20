<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
//        'author_id',
//        'category_id',
//        'title',
//        'slug',
//        'content',
//        'excerpt',

        $title = fake()->unique()->sentence;
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->sentence,
            'content' => fake()->paragraph
        ];
    }
}
