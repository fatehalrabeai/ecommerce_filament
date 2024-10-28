<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\CityFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed other data first
        $this->call([
            CitySeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
        ]);

        // Create some users
        $users = User::factory(10)->create();  // Seed 10 users

        // Create some attributes and attribute values
        $attributes = Attribute::factory(5)->create();

        foreach ($attributes as $attribute) {
            AttributeValue::factory(10)->create([
                'attribute_id' => $attribute->id,
            ]);
        }

        // Create products and their associated attributes
        Product::factory(10)->create()->each(function ($product) use ($attributes) {
            foreach ($attributes as $attribute) {
                $attributeValue = AttributeValue::where('attribute_id', $attribute->id)->inRandomOrder()->first();
                ProductAttribute::factory()->create([
                    'product_id' => $product->id,
                    'attribute_id' => $attribute->id,
                    'attribute_value_id' => $attributeValue->id,
                    'price' => $product->price + random_int(1, 10), // Adjust price with attributes
                ]);
            }
        });

        // Create carts and cart products for users
        $users->each(function ($user) {
            Cart::factory(1)->create([
                'user_id' => $user->id,  // Associate the cart with the user
            ])->each(function ($cart) {
                CartProduct::factory(3)->create([
                    'cart_id' => $cart->id,  // Use the created cart ID
                    'product_id' => Product::inRandomOrder()->first()->id,  // Random product
                ]);
            });
        });

        // Create orders and order products for users
        $users->each(function ($user) {
            Order::factory(2)->create([
                'user_id' => $user->id,  // Associate orders with the user
            ])->each(function ($order) {
                OrderProduct::factory(3)->create([
                    'order_id' => $order->id,  // Use the created order ID
                    'product_id' => Product::inRandomOrder()->first()->id,  // Random product
                ]);
            });
        });
    }
}
