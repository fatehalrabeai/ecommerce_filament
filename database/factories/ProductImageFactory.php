<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'image_name' => fake()->image('public/storage', 640, 480, null, false),
            'image_alt' => fake()->sentence,
            'product_id' => Product::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
