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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 32);
            $table->string('lastname', 32);
            $table->string('email', 96);
            $table->string('phone', 32);
            $table->string('password');
            $table->decimal('balance', 10, 2)->nullable()->default(0.00);
            $table->unsignedInteger('point')->nullable()->default(0);
            $table->string('salt', 9);
            $table->mediumText('wishlist')->nullable();
            $table->boolean('newsletter')->default(0);
            $table->integer('address_id')->default(0);
            $table->string('ip', 40);
            $table->boolean('status')->default(1);
            
            $table->integer('createdBy')->nullable();
            $table->integer('updatedBy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
