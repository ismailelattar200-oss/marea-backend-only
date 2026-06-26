<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menu items are the core of the restaurant's digital carta.
     * Each item belongs to a category and has a display_number for the
     * amber badge shown on the card (numbered sequentially within category).
     * is_available controls real-time availability toggling by staff.
     * is_featured marks items to appear on the homepage featured section.
     */
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('image_url')->nullable();
            $table->unsignedInteger('display_number')->default(0);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index('category_id');
            $table->index('is_available');
            $table->index('is_featured');
            $table->index('display_number');
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
