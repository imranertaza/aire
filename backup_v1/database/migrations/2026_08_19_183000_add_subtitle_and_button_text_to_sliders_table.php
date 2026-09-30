<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            if (!Schema::hasColumn('sliders', 'subtitle')) {
                $table->string('subtitle')->nullable()->after('title');
            }
            if (!Schema::hasColumn('sliders', 'button_text')) {
                $table->string('button_text')->nullable()->after('link');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            if (Schema::hasColumn('sliders', 'subtitle')) {
                $table->dropColumn('subtitle');
            }
            if (Schema::hasColumn('sliders', 'button_text')) {
                $table->dropColumn('button_text');
            }
        });
    }
};
