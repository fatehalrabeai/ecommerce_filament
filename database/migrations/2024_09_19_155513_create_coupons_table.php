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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code')->unique();
            $table->enum('discount_type', ['fixed', 'percentage']);
            $table->decimal('discount_amount', 8, 2);
            $table->decimal('minimum_purchase', 8, 2)->nullable(); // Optional minimum order amount
            $table->integer('usage_limit')->nullable(); // Limit how many times the coupon can be used
            $table->dateTime('expiry_date')->nullable(); // Optional expiry date
            $table->boolean('status')->default(true); // Active or inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
