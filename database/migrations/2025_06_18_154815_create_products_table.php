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
            $table->uuid('id')->primary(); // UUID as primary key

            // Basic Info
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();

            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();

            // Inventory
            $table->unsignedInteger('stock')->default(0);

            // Type & Flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);

            // Dimensions (optional for shipping)
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();

            // Optional JSON Fields
            $table->json('tags')->nullable();          // ["new", "summer", "sale"]
            $table->json('specifications')->nullable(); // {"color":"red", "material":"cotton"}
            $table->boolean('status')->default(true); 

            $table->softDeletes();
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
