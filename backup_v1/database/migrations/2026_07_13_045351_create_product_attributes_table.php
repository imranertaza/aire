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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_group_id')
                ->constrained('product_attribute_groups')
                ->onDelete('cascade');

            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade');

            $table->string('name', 255);
            $table->mediumText('details')->nullable();

            $table->integer('sort_order')->default(0);

            $table->tinyInteger('status')->default(1)
                ->comment('1 = Active, 0 = Inactive');

            $table->unsignedBigInteger('createdBy')->nullable();
            $table->unsignedBigInteger('updatedBy')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['product_id', 'attribute_group_id']);
            $table->index('sort_order');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
