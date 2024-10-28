<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'name' => fake()->word,
            'parent_id' => null, // Assuming some categories are parents
            'slug' => fake()->slug,
            'image_name' => fake()->image('public/storage', 640, 480, null, false),
            'cover_image' => fake()->image('public/storage', 640, 480, null, false),
            'status' => fake()->randomElement(['active', 'inactive']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
