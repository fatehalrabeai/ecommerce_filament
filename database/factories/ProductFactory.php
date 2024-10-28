<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid,
            'name' => fake()->title,
            'brief' => fake()->sentence,
            'description' => fake()->paragraph,
            'slug' => fake()->slug,
            'status' => fake()->randomElement(['active', 'inactive']),
            'expiry_date' => fake()->optional()->date(),
            'avg_rating' => fake()->randomFloat(2, 0, 5),
            'total_ratings' => fake()->numberBetween(0, 1000),
            'sku' => fake()->unique()->numberBetween(100000, 999999),
            'category_id' => Category::factory(),
            'supplier_id' => null,  // Assuming suppliers are not seeded
            'brand_id' => Brand::factory(),  // Correctly reference the Brand factory
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
