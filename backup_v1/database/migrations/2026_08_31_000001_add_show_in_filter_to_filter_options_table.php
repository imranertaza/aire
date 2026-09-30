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
        if (Schema::hasTable('filter_options')) {
            if (!Schema::hasColumn('filter_options', 'show_in_filter')) {
                Schema::table('filter_options', function (Blueprint $table) {
                    $table->tinyInteger('show_in_filter')->default(1)->after('sort_order');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('filter_options') && Schema::hasColumn('filter_options', 'show_in_filter')) {
            Schema::table('filter_options', function (Blueprint $table) {
                $table->dropColumn('show_in_filter');
            });
        }
    }
};
