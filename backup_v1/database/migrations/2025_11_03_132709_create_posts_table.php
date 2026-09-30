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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('post_title', 255);
            $table->text('slug');
            $table->string('short_des', 255);
            $table->longText('description');
            $table->text('meta_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('f_image', 255);
            $table->string('image', 255)->nullable();
            $table->string('alt_name', 255)->nullable();
            $table->timestamp('publish_date')->useCurrent();
            $table->enum('status', ['0', '1'])->default('1');
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
        Schema::dropIfExists('posts');
    }
};
