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
        Schema::create('gallery', function (Blueprint $table) {
            $table->id(); // previously album_id
            $table->string('name', 100);
            $table->string('thumb', 100)->nullable();
            $table->string('alt_name', 255)->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=inactive, 1=active');
            $table->tinyInteger('scope')->default(0)->comment('0 = National, 1 = International 2 = Non Sports');
            $table->integer('sort_order')->default(0);
            $table->integer('createdBy')->nullable();
            $table->integer('updatedBy')->nullable();
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery');
    }
};
