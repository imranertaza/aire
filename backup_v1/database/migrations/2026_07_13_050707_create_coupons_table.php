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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code', 255)->unique();

            // Better to use tinyInteger instead of enum
            $table->tinyInteger('discount_type')->default(1)
                ->comment('1 = Percentage, 2 = Flat');

            $table->tinyInteger('discount_on')->default(1)
                ->comment('1 = Product, 2 = Shipping');

            $table->decimal('discount', 7, 5);

            $table->tinyInteger('for_subscribed_user')->default(0)
                ->comment('1 = Yes, 0 = No');

            $table->tinyInteger('for_registered_user')->default(0)
                ->comment('1 = Yes, 0 = No');

            $table->integer('total_useable')->nullable();
            $table->integer('total_used')->default(0);

            $table->date('date_start');
            $table->date('date_end');

            $table->tinyInteger('status')->default(1)
                ->comment('1 = Active, 0 = Inactive');

            $table->unsignedBigInteger('createdBy')->nullable();
            $table->unsignedBigInteger('updatedBy')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('code');
            $table->index('status');
            $table->index(['date_start', 'date_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
