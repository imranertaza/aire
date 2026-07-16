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
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_descriptions');
    }
};
