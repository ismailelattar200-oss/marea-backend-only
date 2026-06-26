<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Order items provide a normalized breakdown of each order.
     * While orders.items stores a JSON snapshot for display,
     * order_items enables relational queries, reporting, and
     * proper referential integrity to menu_items.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade');
            $table->foreignId('menu_item_id')
                  ->constrained('menu_items')
                  ->onDelete('cascade');
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 8, 2);
            $table->timestamps();

            $table->index('order_id');
            $table->index('menu_item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
