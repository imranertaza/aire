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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete()->comment('Associated Order ID');
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete()->comment('Associated Product ID');
            $table->double('price')->comment('Unit price of the product');
            $table->integer('quantity')->comment('Quantity purchased');
            $table->double('total_price')->comment('Total price before discount');
            $table->integer('discount')->nullable()->comment('Applied discount value or percentage');
            $table->double('final_price')->comment('Final price after discount');
            $table->unsignedBigInteger('createdBy')->nullable();
            $table->unsignedBigInteger('updatedBy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
