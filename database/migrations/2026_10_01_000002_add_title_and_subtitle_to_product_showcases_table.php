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
        if (Schema::hasTable('product_showcases')) {
            Schema::table('product_showcases', function (Blueprint $table) {
                if (!Schema::hasColumn('product_showcases', 'title')) {
                    $table->string('title')->nullable()->after('product_id');
                }
                if (!Schema::hasColumn('product_showcases', 'subtitle')) {
                    $table->string('subtitle')->nullable()->after('title');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('product_showcases')) {
            Schema::table('product_showcases', function (Blueprint $table) {
                if (Schema::hasColumn('product_showcases', 'subtitle')) {
                    $table->dropColumn('subtitle');
                }
                if (Schema::hasColumn('product_showcases', 'title')) {
                    $table->dropColumn('title');
                }
            });
        }
    }
};
