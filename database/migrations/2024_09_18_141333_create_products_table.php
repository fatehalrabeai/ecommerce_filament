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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name',250);
            $table->text('brief')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->unique()->index();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('expiry_date')->nullable();
            $table->float('avg_rating')->default(0);
            $table->integer('total_ratings')->default(0);
            $table->decimal('base_price', 10, 2)->default(0);
            $table->string('sku')->unique();

            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
