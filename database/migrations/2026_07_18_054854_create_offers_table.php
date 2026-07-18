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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Name of the offer');
            $table->string('key')->default('general_offer')->comment('Key grouping of the offer');
            $table->text('description')->nullable()->comment('Detailed description');
            $table->string('banner')->nullable()->comment('Image filename');
            $table->string('alt_name', 155)->nullable();
            $table->text('slug')->nullable();
            $table->tinyInteger('offer_type')->default(1)->comment('1: distinct, 2: indistinct. Distinct means if anyone takes an offer, he cannot take any other offer with the amount he is buying.');
            $table->tinyInteger('offer_on')->default(2)->comment('1: product, 2: amount');
            $table->integer('qty')->nullable();
            $table->decimal('on_amount', 10, 2)->default(0.00);
            $table->tinyInteger('discount_on')->default(2)->comment('1: product, 2: product_amount, 3: shipping_amount');
            $table->tinyInteger('discount_percent')->default(0)->comment('0: false, 1: true');
            $table->tinyInteger('discount_amount')->default(0)->comment('0: false, 1: true');
            $table->double('amount')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('expire_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
