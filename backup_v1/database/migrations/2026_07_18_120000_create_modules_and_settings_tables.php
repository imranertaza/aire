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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('module_key', 50)->unique();
            $table->tinyInteger('status')->default(0)->comment('0: Inactive, 1: Active');
            $table->timestamps();
        });

        Schema::create('module_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();
            $table->string('setting_key', 100);
            $table->string('title', 255);
            $table->string('value', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_settings');
        Schema::dropIfExists('modules');
    }
};
