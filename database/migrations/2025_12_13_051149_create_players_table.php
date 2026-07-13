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
        Schema::create('players', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto_increment

            // Core info
            $table->string('name', 255);
            $table->string('sport', 255);
            $table->string('position', 255)->nullable();
            $table->string('team', 255)->nullable(); // added

            // Media
            $table->string('image', 255)->nullable();

            // Personal details
            $table->date('birthdate')->nullable();
            $table->string('country', 255)->nullable();
            $table->string('height', 50)->nullable();
            $table->string('weight', 50)->nullable();
            $table->string('hometown', 255)->nullable();

            // Rankings
            $table->string('asian_ranking', 50)->nullable();
            $table->string('national_ranking', 50)->nullable();

            // Derived info
            $table->integer('age')->nullable(); // added

            // Slug & status
            $table->string('slug', 255)->unique();
            $table->tinyInteger('status')->default(1); // 0=inactive, 1=active

            // Audit
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
        Schema::dropIfExists('players');
    }
};
