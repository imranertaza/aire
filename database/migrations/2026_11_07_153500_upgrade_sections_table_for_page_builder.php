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
        Schema::table('sections', function (Blueprint $table) {
            if (!Schema::hasColumn('sections', 'page_name')) {
                $table->string('page_name')->default('home')->after('name');
            }
            if (!Schema::hasColumn('sections', 'section_type')) {
                $table->string('section_type')->nullable()->after('page_name');
            }
            if (!Schema::hasColumn('sections', 'order')) {
                $table->integer('order')->default(0)->after('data');
            }
            if (!Schema::hasColumn('sections', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('order');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $columns = [];
            foreach (['page_name', 'section_type', 'order', 'is_active'] as $col) {
                if (Schema::hasColumn('sections', $col)) {
                    $columns[] = $col;
                }
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
