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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('father_name', 155)->nullable();
            $table->string('mother_name', 155)->nullable();
            $table->integer('age')->nullable();
            $table->string('nid', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('pic', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['father_name', 'mother_name', 'age', 'nid', 'address', 'pic']);
        });
    }
};
