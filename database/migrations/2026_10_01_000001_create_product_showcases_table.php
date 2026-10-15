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
        Schema::create('product_showcases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // Header & Badges
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('series_badge')->nullable();
            $table->string('badge_residential')->nullable()->default('Residential');
            $table->string('badge_fresh_air')->nullable()->default('Small Fresh Air');
            
            // Images
            $table->string('hero_bg_image')->nullable();
            $table->string('diagram_image')->nullable();
            
            // Diagram Box Meta
            $table->string('diagram_brand')->nullable();
            $table->string('diagram_model')->nullable();
            $table->string('diagram_system')->nullable();
            
            // Bottom Specs Bar
            $table->string('airflow')->nullable();
            $table->string('power')->nullable();
            $table->string('coverage_area')->nullable();
            
            // Structured JSON specifications & features
            $table->json('feature_pills')->nullable();
            $table->json('spec_highlights')->nullable();
            $table->json('matched_features')->nullable();
            $table->json('health_tags')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_showcases');
    }
};
