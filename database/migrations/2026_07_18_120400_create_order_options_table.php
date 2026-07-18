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
        Schema::create('order_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete()->comment('Associated Order ID');
            $table->foreignId('order_item_id')->constrained('order_items')->cascadeOnDelete()->comment('Associated Order Item ID');
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete()->comment('Associated Product ID');
            $table->integer('option_id')->comment('Option ID from options table');
            $table->integer('option_value_id')->comment('Option Value ID from option_values table');
            $table->string('name', 255)->comment('Option name (e.g. Size, Color)');
            $table->mediumText('value')->comment('Option value (e.g. XL, Red)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_options');
    }
};
