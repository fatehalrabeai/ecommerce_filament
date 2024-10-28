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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('product_id')->index()->constrained('products')->cascadeOnDelete();
            $table->foreignId('attribute_id')->index()->constrained('attributes')->cascadeOnDelete();
            $table->foreignId('attribute_value_id')->index()->constrained('attribute_values')->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
