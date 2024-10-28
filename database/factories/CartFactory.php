<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
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
            'user_id' => User::factory(),  // Logged-in user or guest
            'session_id' => $this->faker->optional()->uuid(),  // If guest cart
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
