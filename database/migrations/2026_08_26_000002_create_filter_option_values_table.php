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
        Schema::create('filter_option_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filter_option_id')->constrained('filter_options')->onDelete('cascade')->nullable();

            $table->string('name', 155);
            $table->string('image', 255)->nullable();
            $table->integer('sort_order')->default(0);

            $table->tinyInteger('status')->default(1)
                ->comment('1 = Active, 0 = Inactive');

            $table->unsignedBigInteger('createdBy')->nullable();
            $table->unsignedBigInteger('updatedBy')->nullable();

            // Indexes
            $table->index('filter_option_id');
            $table->index('sort_order');
            $table->index('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filter_option_values');
    }
};
