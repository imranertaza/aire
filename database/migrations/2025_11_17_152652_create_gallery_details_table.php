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
        Schema::create('gallery_details', function (Blueprint $table) {
            $table->id(); // previously album_details_id
            $table->foreignId('gallery_id')->constrained('gallery')->onDelete('cascade'); // album_id → gallery_id
            $table->string('image', 155)->nullable();
            $table->string('alt_name', 255)->nullable();
            $table->integer('sort_order')->default(0);
            $table->integer('createdBy')->nullable();
            $table->integer('updatedBy')->nullable();
            $table->timestamps(); // created_at & updated_at
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_details');
    }
};
