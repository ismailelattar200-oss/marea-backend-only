<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'pret' back to the enum for orders and deliveries
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('en_attente', 'en_preparation', 'pret', 'en_cours', 'livre', 'annule') DEFAULT 'en_attente'");
        DB::statement("ALTER TABLE deliveries MODIFY COLUMN status ENUM('en_attente', 'en_preparation', 'pret', 'en_cours', 'livre') DEFAULT 'en_attente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('en_attente', 'en_cours', 'en_preparation', 'livre', 'annule') DEFAULT 'en_attente'");
        DB::statement("ALTER TABLE deliveries MODIFY COLUMN status ENUM('en_attente', 'en_cours', 'en_preparation', 'livre') DEFAULT 'en_attente'");
    }
};
