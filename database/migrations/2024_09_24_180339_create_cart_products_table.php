<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('cart_id')->index()->constrained()->onDelete('cascade');  // Links to the cart
            $table->foreignId('product_id')->index()->constrained()->onDelete('cascade');  // Links to the product
            // New fields for handling product attributes
            $table->foreignId('attribute_id')->index()->nullable()->constrained('attributes')->onDelete('cascade');
            $table->foreignId('attribute_value_id')->index()->nullable()->constrained('attribute_values')->onDelete('cascade');

            $table->integer('quantity')->default(1);  // Quantity of the product in the cart
            $table->decimal('price', 10, 2);  // Price of the product at the time of addition

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_products');
    }
};
