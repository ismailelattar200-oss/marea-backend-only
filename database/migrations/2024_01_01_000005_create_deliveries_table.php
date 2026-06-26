<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Deliveries track the full delivery lifecycle for orders of type 'domicilio'.
     * This is the KEY FEATURE for the restaurant's delivery management (Repartos).
     *
     * Status flow: asignado → recogido → en_camino → entregado
     *
     * Timestamps (assigned_at, picked_up_at, delivered_at) enable
     * delivery time analytics and driver performance tracking.
     */
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade');
            $table->foreignId('delivery_person_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->enum('status', [
                'assigne',
                'recupere',
                'en_route',
                'livre'
            ])->default('assigne');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('delivery_person_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
