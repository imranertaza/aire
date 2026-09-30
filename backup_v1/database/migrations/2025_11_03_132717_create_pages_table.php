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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('temp', 255)->nullable()->default('default');
            $table->string('page_title', 255);
            $table->string('breadcrumb', 255);
            $table->string('slug', 300);
            $table->string('short_des', 255)->nullable();
            $table->longText('page_description')->nullable();
            $table->string('f_image', 255)->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('meta_keyword', 255)->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->foreignId('createdBy')->constrained('users');
            $table->foreignId('updatedBy')->nullable()->constrained('users');
            $table->timestamps();
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
