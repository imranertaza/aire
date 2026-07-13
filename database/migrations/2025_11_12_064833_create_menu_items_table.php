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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('icon')->nullable();
            $table->enum('link_type', ['page', 'category', 'url'])->default('url');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->text('url')->nullable();
            $table->foreignId('page_id')
                ->nullable()
                ->constrained('pages')
                ->nullOnDelete();
            $table->boolean('enabled')->default(true);
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->onDelete('cascade');
            $table->integer('order')->default(0);

            $table->index(['menu_id', 'parent_id', 'order']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
