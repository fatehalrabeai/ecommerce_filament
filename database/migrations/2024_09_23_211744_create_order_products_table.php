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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('order_id')->index()->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->index()->constrained()->onDelete('cascade');

            // New fields for handling product attributes
            $table->foreignId('attribute_id')->index()->nullable()->constrained('attributes')->onDelete('cascade');
            $table->foreignId('attribute_value_id')->index()->nullable()->constrained('attribute_values')->onDelete('cascade');

            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Price at the time of ordering
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
