<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_descriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->mediumText('tag')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('meta_keyword', 255)->nullable();
            $table->string('description_image', 255)->nullable();
            $table->string('documentation_pdf', 255)->nullable();
            $table->string('safety_pdf', 255)->nullable();
            $table->string('instructions_pdf', 255)->nullable();
            $table->string('video', 255)->nullable();

            // Specifications Section Fields (Section 2)
            $table->string('specs_badge', 255)->nullable();
            $table->string('specs_title', 255)->nullable();
            $table->text('specs_description')->nullable();
            $table->string('specs_image', 255)->nullable();
            $table->string('spec1_icon', 255)->nullable();
            $table->string('spec1_badge', 255)->nullable();
            $table->string('spec1_value', 255)->nullable();
            $table->string('spec1_unit', 255)->nullable();
            $table->string('spec1_desc', 255)->nullable();
            $table->string('spec2_icon', 255)->nullable();
            $table->string('spec2_badge', 255)->nullable();
            $table->string('spec2_value', 255)->nullable();
            $table->string('spec2_unit', 255)->nullable();
            $table->string('spec2_desc', 255)->nullable();
            $table->string('spec3_icon', 255)->nullable();
            $table->string('spec3_badge', 255)->nullable();
            $table->string('spec3_value', 255)->nullable();
            $table->string('spec3_unit', 255)->nullable();
            $table->string('spec3_desc', 255)->nullable();
            $table->string('spec4_icon', 255)->nullable();
            $table->string('spec4_badge', 255)->nullable();
            $table->string('spec4_value', 255)->nullable();
            $table->string('spec4_unit', 255)->nullable();
            $table->string('spec4_desc', 255)->nullable();

            // Features Section Fields (Section 3)
            $table->string('features_badge', 255)->nullable();
            $table->string('features_title', 255)->nullable();
            $table->text('features_description')->nullable();
            $table->string('features_image', 255)->nullable();
            $table->string('feature1_icon', 255)->nullable();
            $table->string('feature1_title', 255)->nullable();
            $table->text('feature1_desc')->nullable();
            $table->string('feature2_icon', 255)->nullable();
            $table->string('feature2_title', 255)->nullable();
            $table->text('feature2_desc')->nullable();
            $table->string('feature3_icon', 255)->nullable();
            $table->string('feature3_title', 255)->nullable();
            $table->text('feature3_desc')->nullable();

            // Applications Section Header
            $table->string('applications_title', 255)->nullable();
            $table->text('applications_description')->nullable();

            // Technology Section Fields
            $table->string('technology_badge', 255)->nullable();
            $table->string('technology_title', 255)->nullable();
            $table->text('technology_description')->nullable();
            $table->string('technology_image', 255)->nullable();
            $table->string('technology_card_title', 255)->nullable();
            $table->text('technology_card_description')->nullable();
            $table->string('tech_feature1_title', 255)->nullable();
            $table->text('tech_feature1_desc')->nullable();
            $table->string('tech_feature2_title', 255)->nullable();
            $table->text('tech_feature2_desc')->nullable();
            $table->string('tech_feature3_title', 255)->nullable();
            $table->text('tech_feature3_desc')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_descriptions');
    }
};
