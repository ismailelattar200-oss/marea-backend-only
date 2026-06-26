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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_first_name')->nullable()->after('customer_name');
            $table->string('customer_last_name')->nullable()->after('customer_first_name');
            $table->string('customer_region')->nullable()->after('customer_address');
            $table->string('customer_city')->nullable()->after('customer_region');
            $table->string('customer_postal_code')->nullable()->after('customer_city');
            $table->string('payment_method')->default('especes')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_first_name',
                'customer_last_name',
                'customer_region',
                'customer_city',
                'customer_postal_code',
                'payment_method'
            ]);
        });
    }
};
