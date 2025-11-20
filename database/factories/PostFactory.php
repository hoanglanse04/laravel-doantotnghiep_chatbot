<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $title = $this->faker->sentence(6);

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . rand(100, 999),
            'content' => $this->faker->paragraphs(5, true),
            'image' => null,
            'status' => $this->faker->randomElement(['draft', 'published']),
            'meta_title' => $title,
            'meta_keywords' => implode(',', $this->faker->words(5)),
            'meta_description' => $this->faker->sentence(10),
            'published_at' => $this->faker->randomElement([now(), null]),
        ];
    }
}
