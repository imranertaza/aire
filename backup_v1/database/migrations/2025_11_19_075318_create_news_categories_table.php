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
        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->foreignId('parent_id')->nullable()->constrained('news_categories')->onDelete('cascade');
            $table->string('category_name', 255);
            $table->text('description')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('meta_keyword', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('alt_name', 255)->nullable();
            $table->integer('sort_order')->default(0);
            $table->enum('status', ['1', '0'])->default('1');
            $table->unsignedInteger('createdBy')->nullable();
            $table->unsignedInteger('updatedBy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_categories');
    }
};
