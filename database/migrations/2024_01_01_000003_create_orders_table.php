<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Orders represent customer pickup/delivery orders.
     * order_number is a unique human-readable identifier (e.g. MAR-20240101-001).
     * user_id is nullable to support guest ordering.
     * items stores a JSON snapshot of the order contents at time of placement.
     * status tracks the order lifecycle: pendiente → preparando → listo → entregado → cancelado.
     * assigned_to references a delivery-role user for delivery orders.
     * type distinguishes between pickup and delivery orders.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->string('customer_address')->nullable();
            $table->dateTime('pickup_time')->nullable();
            $table->json('items');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total', 10, 2);
            $table->enum('status', [
                'en_attente',
                'en_preparation',
                'pret',
                'livre',
                'annule'
            ])->default('en_attente');
            $table->enum('type', ['a_emporter', 'livraison'])->default('a_emporter');
            $table->text('notes')->nullable();
            $table->foreignId('assigned_to')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            $table->timestamps();

            $table->index('order_number');
            $table->index('status');
            $table->index('type');
            $table->index('assigned_to');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
