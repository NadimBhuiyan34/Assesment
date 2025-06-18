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
        Schema::create('categories', function (Blueprint $table) {
             $table->uuid('id')->primary(); // UUID instead of auto-increment

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug')->unique();

            // parent_id is also UUID
            $table->uuid('parent_id')->nullable();
            $table->boolean('status')->default(true); 

            $table->timestamps();

            // Foreign key referencing same table (UUID)
            $table->foreign('parent_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
