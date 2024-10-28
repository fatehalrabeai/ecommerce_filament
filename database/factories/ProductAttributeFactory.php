<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttribute>
 */
class ProductAttributeFactory extends Factory
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
            'product_id' => Product::factory(),
            'attribute_id' => Attribute::factory(),
            'attribute_value_id' => AttributeValue::factory(),
            'price' => $this->faker->randomFloat(2, 10, 200),  // Random price
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
