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
        Schema::create('product_overviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            
            // Feature card 1
            $table->string('feature1_icon')->nullable();
            $table->string('feature1_title')->nullable();
            $table->text('feature1_desc')->nullable();

            // Feature card 2
            $table->string('feature2_icon')->nullable();
            $table->string('feature2_title')->nullable();
            $table->text('feature2_desc')->nullable();

            // Optional HUD labels
            $table->string('hud_label1')->nullable();
            $table->string('hud_label2')->nullable();
            $table->string('hud_label3')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_overviews');
    }
};
