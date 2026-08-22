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
                if (!Schema::hasColumn('product_descriptions', 'applications_title')) {
                    $table->string('applications_title', 255)->nullable()->after('video');
                }
                if (!Schema::hasColumn('product_descriptions', 'applications_description')) {
                    $table->text('applications_description')->nullable()->after('applications_title');
                }
                if (!Schema::hasColumn('product_descriptions', 'technology_badge')) {
                    $table->string('technology_badge', 255)->nullable()->after('applications_description');
                }
                if (!Schema::hasColumn('product_descriptions', 'technology_title')) {
                    $table->string('technology_title', 255)->nullable()->after('technology_badge');
                }
                if (!Schema::hasColumn('product_descriptions', 'technology_description')) {
                    $table->text('technology_description')->nullable()->after('technology_title');
                }
                if (!Schema::hasColumn('product_descriptions', 'technology_image')) {
                    $table->string('technology_image', 255)->nullable()->after('technology_description');
                }
                if (!Schema::hasColumn('product_descriptions', 'technology_card_title')) {
                    $table->string('technology_card_title', 255)->nullable()->after('technology_image');
                }
                if (!Schema::hasColumn('product_descriptions', 'technology_card_description')) {
                    $table->text('technology_card_description')->nullable()->after('technology_card_title');
                }
                if (!Schema::hasColumn('product_descriptions', 'tech_feature1_title')) {
                    $table->string('tech_feature1_title', 255)->nullable()->after('technology_card_description');
                }
                if (!Schema::hasColumn('product_descriptions', 'tech_feature1_desc')) {
                    $table->text('tech_feature1_desc')->nullable()->after('tech_feature1_title');
                }
                if (!Schema::hasColumn('product_descriptions', 'tech_feature2_title')) {
                    $table->string('tech_feature2_title', 255)->nullable()->after('tech_feature1_desc');
                }
                if (!Schema::hasColumn('product_descriptions', 'tech_feature2_desc')) {
                    $table->text('tech_feature2_desc')->nullable()->after('tech_feature2_title');
                }
                if (!Schema::hasColumn('product_descriptions', 'tech_feature3_title')) {
                    $table->string('tech_feature3_title', 255)->nullable()->after('tech_feature2_desc');
                }
                if (!Schema::hasColumn('product_descriptions', 'tech_feature3_desc')) {
                    $table->text('tech_feature3_desc')->nullable()->after('tech_feature3_title');
                }
            });
        }

        if (Schema::hasTable('product_applications')) {
            Schema::table('product_applications', function (Blueprint $table) {
                if (!Schema::hasColumn('product_applications', 'bg_image')) {
                    $table->string('bg_image')->nullable()->after('image');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('product_descriptions')) {
            Schema::table('product_descriptions', function (Blueprint $table) {
                $columns = [
                    'applications_title',
                    'applications_description',
                    'technology_badge',
                    'technology_title',
                    'technology_description',
                    'technology_image',
                    'technology_card_title',
                    'technology_card_description',
                    'tech_feature1_title',
                    'tech_feature1_desc',
                    'tech_feature2_title',
                    'tech_feature2_desc',
                    'tech_feature3_title',
                    'tech_feature3_desc',
                ];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('product_descriptions', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('product_applications') && Schema::hasColumn('product_applications', 'bg_image')) {
            Schema::table('product_applications', function (Blueprint $table) {
                $table->dropColumn('bg_image');
            });
        }
    }
};
