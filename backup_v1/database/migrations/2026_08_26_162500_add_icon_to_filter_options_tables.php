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
        Schema::table('filter_options', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('type');
        });

        Schema::table('filter_option_values', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('filter_options', function (Blueprint $table) {
            $table->dropColumn('icon');
        });

        Schema::table('filter_option_values', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
