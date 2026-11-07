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
        if (Schema::hasTable('product_descriptions')) {
            Schema::table('product_descriptions', function (Blueprint $table) {
                if (!Schema::hasColumn('product_descriptions', 'in_the_box_image')) {
                    $table->string('in_the_box_image', 255)->nullable()->after('in_the_box_description');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('product_descriptions')) {
            Schema::table('product_descriptions', function (Blueprint $table) {
                if (Schema::hasColumn('product_descriptions', 'in_the_box_image')) {
                    $table->dropColumn('in_the_box_image');
                }
            });
        }
    }
};

