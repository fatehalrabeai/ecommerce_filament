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
        Schema::create('category_brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->index()->constrained('categories')->cascadeOnDelete(); // Ensure it points to 'categories'
            $table->foreignId('brand_id')->index()->constrained('brands')->cascadeOnDelete(); // Ensure it points to 'brands'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_brands');
    }
};
