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
                if (!Schema::hasColumn('product_showcases', 'modal_subtitle')) {
                    $table->string('modal_subtitle')->nullable()->after('subtitle');
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
                if (Schema::hasColumn('product_showcases', 'modal_subtitle')) {
                    $table->dropColumn('modal_subtitle');
                }
            });
        }
    }
};
