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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_category_id')
                ->constrained('event_categories')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->tinyInteger('type')->default('0')->comment('2=Past,1=Running, 0=Upcoming')->in_array([0, 1]);
            $table->tinyInteger('event_scope')->default(0)->comment('0 = National, 1 = International, 2 = Non Sports');
            $table->enum('status', ['1', '0'])->default('1');
            $table->foreignId('createdBy')->constrained('users');
            $table->foreignId('updatedBy')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
