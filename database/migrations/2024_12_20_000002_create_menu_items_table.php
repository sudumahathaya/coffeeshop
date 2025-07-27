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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category');
            $table->decimal('price', 8, 2);
            $table->string('image')->nullable();
            $table->string('preparation_time')->nullable();
            $table->json('ingredients')->nullable();
            $table->json('allergens')->nullable();
            $table->integer('calories')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index(['category', 'status']);
            $table->index(['status', 'created_at']);
            $table->index('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};