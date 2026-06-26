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
        Schema::table('menu_items', function (Blueprint $table) {
            $table->decimal('rating', 2, 1)->nullable()->after('price');
        });

        // Set random rating between 4.0 and 4.9 for existing rows
        $items = DB::table('menu_items')->get();
        foreach ($items as $item) {
            DB::table('menu_items')
                ->where('id', $item->id)
                ->update(['rating' => rand(40, 49) / 10]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('rating');
        });
    }
};
