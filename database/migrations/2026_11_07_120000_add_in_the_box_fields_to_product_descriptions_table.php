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
                if (!Schema::hasColumn('product_descriptions', 'in_the_box_badge')) {
                    $table->string('in_the_box_badge', 255)->nullable()->after('tech_feature3_desc');
                }
                if (!Schema::hasColumn('product_descriptions', 'in_the_box_title')) {
                    $table->string('in_the_box_title', 255)->nullable()->after('in_the_box_badge');
                }
                if (!Schema::hasColumn('product_descriptions', 'in_the_box_description')) {
                    $table->text('in_the_box_description')->nullable()->after('in_the_box_title');
                }
                if (!Schema::hasColumn('product_descriptions', 'in_the_box_items')) {
                    $table->json('in_the_box_items')->nullable()->after('in_the_box_description');
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
                $columns = ['in_the_box_badge', 'in_the_box_title', 'in_the_box_description', 'in_the_box_items'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('product_descriptions', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};

