<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'user_id' => User::factory(),
            'total_price' => $this->faker->randomFloat(2, 50, 1000),  // Random total price
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'returned']),
            'ordered_at' => now(),
            'avg_rating' => $this->faker->randomFloat(2, 0, 5),  // Random average rating
            'total_ratings' => $this->faker->numberBetween(0, 1000),
            'receivedMoney' => $this->faker->randomFloat(2, 50, 1000),  // Money received
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
