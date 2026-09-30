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
        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade');

            $table->foreignId('option_id')
                ->constrained('options')
                ->onDelete('cascade');

            $table->foreignId('option_value_id')
                ->constrained('option_values')
                ->onDelete('cascade');

            $table->integer('quantity')->default(0);

            $table->tinyInteger('subtract')->default(1)
                ->comment('1 = Subtract stock, 0 = Do not subtract');

            $table->decimal('price', 15, 4)->nullable();
            $table->string('price_prefix', 1)->nullable();

            $table->integer('points')->nullable();
            $table->string('point_prefix', 1)->nullable();

            $table->decimal('weight', 15, 8)->nullable();
            $table->string('weight_prefix', 1)->nullable();

            $table->timestamps();

            $table->index(['product_id', 'option_id', 'option_value_id']);
            $table->index('product_id');
            $table->index('option_value_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_options');
    }
};
