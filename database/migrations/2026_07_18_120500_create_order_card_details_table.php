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
        Schema::create('order_card_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete()->comment('Associated Order ID');
            $table->integer('payment_method_id')->comment('Payment Method ID');
            $table->string('card_name', 255)->comment('Name printed on card');
            $table->bigInteger('card_number')->comment('Debit/Credit Card Number');
            $table->string('card_expiration', 155)->comment('Card expiration date MM/YY');
            $table->integer('card_cvc')->comment('Card verification code');
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
        Schema::dropIfExists('order_card_details');
    }
};
