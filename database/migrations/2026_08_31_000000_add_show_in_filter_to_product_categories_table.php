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
        if (Schema::hasTable('product_categories')) {
            if (!Schema::hasColumn('product_categories', 'show_in_filter')) {
                Schema::table('product_categories', function (Blueprint $table) {
                    $table->tinyInteger('show_in_filter')->default(0)->after('side_menu');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('product_categories') && Schema::hasColumn('product_categories', 'show_in_filter')) {
            Schema::table('product_categories', function (Blueprint $table) {
                $table->dropColumn('show_in_filter');
            });
        }
    }
};
