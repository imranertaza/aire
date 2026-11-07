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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_category_id')->constrained('resource_categories')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->foreignId('product_category_id')->nullable()->constrained('product_categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('file_type')->nullable(); // pdf, zip, xlsx, docx, apk, video, faq, link
            $table->string('file_path')->nullable(); // filename or file url
            $table->string('file_size')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('badge_icon')->nullable();
            $table->string('badge_text')->nullable();
            $table->string('external_url')->nullable();
            $table->json('metadata')->nullable(); // e.g. answer, faq_target, video_src, button_text
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('is_featured')->default(0)->comment('1 = Yes, 0 = No');
            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();

            $table->index(['resource_category_id', 'status', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
