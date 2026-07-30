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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->string('name', 255);
            $table->string('model', 255);
            $table->string('product_code')->nullable();

            $table->text('main_image')->nullable();
            $table->text('image')->nullable();           // For multiple images as JSON or comma separated
            $table->string('alt_name', 255)->nullable();

            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('cascade');

            $table->decimal('price', 10, 2);
            $table->integer('quantity');

            $table->tinyInteger('featured')->default(0)->comment('1 = Yes, 0 = No');
            $table->integer('average_feedback')->nullable();

            $table->date('date_available')->nullable();

            $table->decimal('weight', 10, 4)->default(0.0000);
            $table->decimal('length', 10, 4)->default(0.0000);
            $table->decimal('width', 10, 4)->default(0.0000);
            $table->decimal('height', 10, 4)->default(0.0000);

            $table->integer('sort_order')->default(0);

            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Inactive');

            $table->unsignedBigInteger('createdBy')->nullable();
            $table->unsignedBigInteger('updatedBy')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('store_id');
            $table->index('brand_id');
            $table->index('status');
            $table->index('featured');
            $table->index('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
