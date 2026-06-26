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
        // 1. Change status columns to VARCHAR to allow any string
        DB::statement("ALTER TABLE orders MODIFY COLUMN status VARCHAR(50) DEFAULT 'en_attente'");
        DB::statement("ALTER TABLE deliveries MODIFY COLUMN status VARCHAR(50) DEFAULT 'en_attente'");

        // 2. Map existing 'orders' statuses
        // Current: en_attente, en_preparation, pret, livre, annule
        // Mapping: pret -> en_cours (since pret means it's ready, but now en_cours means livreur is assigned/preparing to deliver)
        DB::table('orders')->where('status', 'pret')->update(['status' => 'en_cours']);

        // 3. Map existing 'deliveries' statuses
        // Current: assigne, recupere, en_route, livre
        DB::table('deliveries')->where('status', 'assigne')->update(['status' => 'en_cours']);
        DB::table('deliveries')->where('status', 'recupere')->update(['status' => 'en_cours']);
        DB::table('deliveries')->where('status', 'en_route')->update(['status' => 'en_preparation']);

        // 4. Change status columns back to ENUM with new values
        // Note: doctrine/dbal may complain about ENUM modifications, so we use raw SQL
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('en_attente', 'en_cours', 'en_preparation', 'livre', 'annule') DEFAULT 'en_attente'");
        DB::statement("ALTER TABLE deliveries MODIFY COLUMN status ENUM('en_attente', 'en_cours', 'en_preparation', 'livre') DEFAULT 'en_attente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert columns to VARCHAR to allow rollback mapping
        DB::statement("ALTER TABLE orders MODIFY COLUMN status VARCHAR(50) DEFAULT 'en_attente'");
        DB::statement("ALTER TABLE deliveries MODIFY COLUMN status VARCHAR(50) DEFAULT 'assigne'");

        // Rollback deliveries mapping
        DB::table('deliveries')->where('status', 'en_cours')->update(['status' => 'assigne']);
        DB::table('deliveries')->where('status', 'en_preparation')->update(['status' => 'en_route']);

        // Rollback orders mapping
        DB::table('orders')->where('status', 'en_cours')->update(['status' => 'pret']);

        // Revert to original ENUMs
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('en_attente', 'en_preparation', 'pret', 'livre', 'annule') DEFAULT 'en_attente'");
        DB::statement("ALTER TABLE deliveries MODIFY COLUMN status ENUM('assigne', 'recupere', 'en_route', 'livre') DEFAULT 'assigne'");
    }
};
