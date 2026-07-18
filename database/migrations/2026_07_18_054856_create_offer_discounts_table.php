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
        Schema::create('offer_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->integer('product_id')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('shipping_method_id')->nullable();
            $table->integer('geo_zone_id')->nullable();
            $table->tinyInteger('discount_calculate_on')->default(2)->comment('1: percentage, 2: fixed');
            $table->double('discount_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_discounts');
    }
};
