<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('product_categories')) {
            if (!Schema::hasColumn('product_categories', 'bg_color')) {
                Schema::table('product_categories', function (Blueprint $table) {
                    $table->string('bg_color', 50)->nullable()->default('#00c853')->after('alt_name');
                });
            }

            // Set nice default colors for categories if not present
            $colorMap = [
                'hospital'     => '#00c853',
                'healthcare'   => '#00c853',
                'medical'      => '#00c853',
                'residential'  => '#0066cc',
                'commercial'   => '#7c3aed',
                'industrial'   => '#f59e0b',
                'education'    => '#0d9488',
                'cleanroom'    => '#06b6d4',
                'laboratory'   => '#6366f1',
            ];

            foreach ($colorMap as $keyword => $hex) {
                DB::table('product_categories')
                    ->where(function ($q) use ($keyword) {
                        $q->where('category_name', 'like', "%{$keyword}%")
                          ->orWhere('alt_name', 'like', "%{$keyword}%")
                          ->orWhere('slug', 'like', "%{$keyword}%");
                    })
                    ->update(['bg_color' => $hex]);
            }

            // Ensure any nulls get fallback
            DB::table('product_categories')
                ->whereNull('bg_color')
                ->orWhere('bg_color', '')
                ->update(['bg_color' => '#00c853']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('product_categories') && Schema::hasColumn('product_categories', 'bg_color')) {
            Schema::table('product_categories', function (Blueprint $table) {
                $table->dropColumn('bg_color');
            });
        }
    }
};
