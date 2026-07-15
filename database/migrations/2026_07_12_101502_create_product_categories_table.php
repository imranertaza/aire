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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name', 155);
            $table->mediumText('description')->nullable();

            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('meta_keyword', 255)->nullable();
            $table->text('icon_class')->nullable();
            $table->unsignedBigInteger('icon_id')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('alt_name', 255)->nullable();

            // Boolean-like fields using tinyInteger (better performance than enum)
            $table->tinyInteger('header_menu')->default(0)
                ->comment('1 = Yes, 0 = No');

            $table->tinyInteger('side_menu')->default(0)
                ->comment('1 = Yes, 0 = No');

            $table->integer('sort_order')->default(0)
                ->comment('Sort order');

            $table->tinyInteger('status')->default(1)
                ->comment('1 = Active, 0 = Inactive');

            $table->unsignedBigInteger('createdBy')->nullable();
            $table->unsignedBigInteger('updatedBy')->nullable();

            $table->foreignId('parent_id')->nullable()->constrained('product_categories')->onDelete('cascade');
            $table->timestamps();


            // Indexes
            $table->index('parent_id');
            $table->index('status');
            $table->index('sort_order');
            $table->index('header_menu');
            $table->index('side_menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
