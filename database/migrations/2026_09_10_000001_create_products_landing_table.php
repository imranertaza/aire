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
        Schema::create('products_landing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->unique();
            $table->tinyInteger('status')->default(1)->comment('1: Enabled, 0: Disabled');

            // Hero Section (Also reused by Bottom CTA Section)
            $table->string('hero_tag')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_button_text')->nullable();
            $table->string('hero_button_url')->nullable();
            $table->string('hero_image')->nullable();

            // Science of Synthesis Section
            $table->string('science_tag')->nullable();
            $table->text('science_title')->nullable();
            $table->text('science_description')->nullable();
            $table->string('science_stat1_value')->nullable();
            $table->string('science_stat1_label')->nullable();
            $table->string('science_stat2_value')->nullable();
            $table->string('science_stat2_label')->nullable();
            $table->string('science_image')->nullable();
            $table->json('science_features')->nullable(); // Array of [{title, desc}]

            // Lifestyle Integration Section
            $table->string('lifestyle_tag')->nullable();
            $table->text('lifestyle_title')->nullable();
            $table->text('lifestyle_description')->nullable();
            $table->string('lifestyle_button_text')->nullable();
            $table->string('lifestyle_button_url')->nullable();
            $table->string('lifestyle_image')->nullable();

            // Medical-Grade Precision Filter Tech Section
            $table->string('filter_tech_title')->nullable();
            $table->text('filter_tech_description')->nullable();
            $table->text('filter_tech_badge_text')->nullable();
            $table->string('filter_tech_image')->nullable();

            // Precision Engineering Specs Section
            $table->string('specs_title')->nullable();
            $table->text('specs_subtitle')->nullable();
            $table->string('specs_image')->nullable();
            $table->string('specs_button_text')->nullable();
            $table->string('specs_button_url')->nullable();
            $table->json('specs_groups')->nullable(); // Array of [{tag, title, image, items: [{label, value}]}]

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_landing');
    }
};
