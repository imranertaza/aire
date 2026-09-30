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
        Schema::create('order_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete()->comment('Associated Order ID');
            $table->tinyInteger('order_status_id')->comment('Order Status ID. 1: Pending, 2: Processing, ...');
            $table->boolean('notify')->default(0)->comment('1: customer notified, 0: not notified');
            $table->mediumText('comment')->comment('History log comment text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_histories');
    }
};
