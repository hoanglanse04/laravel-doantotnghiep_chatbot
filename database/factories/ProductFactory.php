<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(5),
            'sku' => Str::random(8),
            'content' => $this->faker->paragraphs(5, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(10000, 500000),
            'discount_price' => function (array $attributes) {
                return $attributes['price'] > 100000 ? $attributes['price'] - rand(5000, 20000) : 0;
            },
            'stock' => $this->faker->numberBetween(0, 100),
            'image' => null,
            'status' => $this->faker->randomElement(['draft', 'published']),
            'published_at' => now(),
            'meta_title' => $this->faker->sentence(),
            'meta_keywords' => implode(',', $this->faker->words(5)),
            'meta_description' => $this->faker->paragraph(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
