<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Job applications from the "Trabaja con nosotros" page.
     * cv_path stores the path to the uploaded CV file in Laravel storage.
     * is_reviewed tracks whether admin has processed the application.
     */
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('position');
            $table->text('message')->nullable();
            $table->string('cv_path')->nullable();
            $table->boolean('is_reviewed')->default(false);
            $table->timestamps();

            $table->index('is_reviewed');
            $table->index('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
