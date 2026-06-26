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
        // 1. Table promotions
        if (!Schema::hasTable('promotions')) {
            Schema::create('promotions', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('discount_type')->default('percentage'); // 'percentage' or 'fixed'
                $table->decimal('discount_value', 8, 2);
                $table->decimal('min_order_amount', 8, 2)->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamp('starts_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->integer('usage_count')->default(0);
                $table->decimal('sales_generated', 12, 2)->default(0);
                $table->timestamps();
            });
        }

        // 2. Table feedbacks
        if (!Schema::hasTable('feedbacks')) {
            Schema::create('feedbacks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
                $table->string('customer_name')->default('Anonyme');
                $table->integer('rating')->default(5); // 1 to 5
                $table->text('comment')->nullable();
                $table->string('sentiment')->default('positive'); // 'positive', 'neutral', 'negative'
                $table->json('complaint_tags')->nullable(); // e.g. ["retard", "froid"]
                $table->timestamps();
            });
        }

        // 3. Tracking GPS & Fleet status on users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'current_lat')) {
                $table->decimal('current_lat', 10, 7)->nullable();
            }
            if (!Schema::hasColumn('users', 'current_lng')) {
                $table->decimal('current_lng', 10, 7)->nullable();
            }
            if (!Schema::hasColumn('users', 'is_available')) {
                $table->boolean('is_available')->default(true);
            }
            if (!Schema::hasColumn('users', 'last_location_update')) {
                $table->timestamp('last_location_update')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('promotions');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['current_lat', 'current_lng', 'is_available', 'last_location_update']);
        });
    }
};
