<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('product_descriptions')) {
            Schema::table('product_descriptions', function (Blueprint $table) {
                if (!Schema::hasColumn('product_descriptions', 'features_badge')) {
                    $table->string('features_badge', 255)->nullable()->after('video');
                }
                if (!Schema::hasColumn('product_descriptions', 'features_title')) {
                    $table->string('features_title', 255)->nullable()->after('features_badge');
                }
                if (!Schema::hasColumn('product_descriptions', 'features_description')) {
                    $table->text('features_description')->nullable()->after('features_title');
                }
                if (!Schema::hasColumn('product_descriptions', 'features_image')) {
                    $table->string('features_image', 255)->nullable()->after('features_description');
                }
                if (!Schema::hasColumn('product_descriptions', 'feature1_icon')) {
                    $table->string('feature1_icon', 255)->nullable()->after('features_image');
                }
                if (!Schema::hasColumn('product_descriptions', 'feature1_title')) {
                    $table->string('feature1_title', 255)->nullable()->after('feature1_icon');
                }
                if (!Schema::hasColumn('product_descriptions', 'feature1_desc')) {
                    $table->text('feature1_desc')->nullable()->after('feature1_title');
                }
                if (!Schema::hasColumn('product_descriptions', 'feature2_icon')) {
                    $table->string('feature2_icon', 255)->nullable()->after('feature1_desc');
                }
                if (!Schema::hasColumn('product_descriptions', 'feature2_title')) {
                    $table->string('feature2_title', 255)->nullable()->after('feature2_icon');
                }
                if (!Schema::hasColumn('product_descriptions', 'feature2_desc')) {
                    $table->text('feature2_desc')->nullable()->after('feature2_title');
                }
                if (!Schema::hasColumn('product_descriptions', 'feature3_icon')) {
                    $table->string('feature3_icon', 255)->nullable()->after('feature2_desc');
                }
                if (!Schema::hasColumn('product_descriptions', 'feature3_title')) {
                    $table->string('feature3_title', 255)->nullable()->after('feature3_icon');
                }
                if (!Schema::hasColumn('product_descriptions', 'feature3_desc')) {
                    $table->text('feature3_desc')->nullable()->after('feature3_title');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('product_descriptions')) {
            Schema::table('product_descriptions', function (Blueprint $table) {
                $columns = [
                    'features_badge',
                    'features_title',
                    'features_description',
                    'features_image',
                    'feature1_icon',
                    'feature1_title',
                    'feature1_desc',
                    'feature2_icon',
                    'feature2_title',
                    'feature2_desc',
                    'feature3_icon',
                    'feature3_title',
                    'feature3_desc',
                ];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('product_descriptions', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
