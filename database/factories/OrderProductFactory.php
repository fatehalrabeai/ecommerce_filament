<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
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
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'attribute_id' => Attribute::factory(),
            'attribute_value_id' => AttributeValue::factory(),
            'quantity' => $this->faker->numberBetween(1, 5),  // Random quantity
            'price' => $this->faker->randomFloat(2, 10, 200),  // Random price at the time of ordering
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
