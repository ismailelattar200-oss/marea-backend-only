<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Gallery photos are displayed on the public Galería page.
     * The category enum separates food/restaurant photos ('galeria')
     * from staff/team photos ('personal'), controlled by the tab toggle.
     * display_order allows admin to control the visual arrangement.
     */
    public function up(): void
    {
        Schema::create('gallery_photos', function (Blueprint $table) {
            $table->id();
            $table->string('image_url');
            $table->enum('category', ['galeria', 'personal'])->default('galeria');
            $table->string('caption')->nullable();
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();

            $table->index('category');
            $table->index('display_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_photos');
    }
};
