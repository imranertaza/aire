<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('product_descriptions')) {
            Schema::table('product_descriptions', function (Blueprint $table) {
                if (!Schema::hasColumn('product_descriptions', 'specs_badge')) {
                    $table->string('specs_badge', 255)->nullable()->after('video');
                }
                if (!Schema::hasColumn('product_descriptions', 'specs_title')) {
                    $table->string('specs_title', 255)->nullable()->after('specs_badge');
                }
                if (!Schema::hasColumn('product_descriptions', 'specs_description')) {
                    $table->text('specs_description')->nullable()->after('specs_title');
                }
                if (!Schema::hasColumn('product_descriptions', 'specs_image')) {
                    $table->string('specs_image', 255)->nullable()->after('specs_description');
                }

                // Stat 1
                if (!Schema::hasColumn('product_descriptions', 'spec1_icon')) {
                    $table->string('spec1_icon', 255)->nullable()->after('specs_image');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec1_badge')) {
                    $table->string('spec1_badge', 255)->nullable()->after('spec1_icon');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec1_value')) {
                    $table->string('spec1_value', 255)->nullable()->after('spec1_badge');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec1_unit')) {
                    $table->string('spec1_unit', 255)->nullable()->after('spec1_value');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec1_desc')) {
                    $table->string('spec1_desc', 255)->nullable()->after('spec1_unit');
                }

                // Stat 2
                if (!Schema::hasColumn('product_descriptions', 'spec2_icon')) {
                    $table->string('spec2_icon', 255)->nullable()->after('spec1_desc');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec2_badge')) {
                    $table->string('spec2_badge', 255)->nullable()->after('spec2_icon');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec2_value')) {
                    $table->string('spec2_value', 255)->nullable()->after('spec2_badge');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec2_unit')) {
                    $table->string('spec2_unit', 255)->nullable()->after('spec2_value');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec2_desc')) {
                    $table->string('spec2_desc', 255)->nullable()->after('spec2_unit');
                }

                // Stat 3
                if (!Schema::hasColumn('product_descriptions', 'spec3_icon')) {
                    $table->string('spec3_icon', 255)->nullable()->after('spec2_desc');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec3_badge')) {
                    $table->string('spec3_badge', 255)->nullable()->after('spec3_icon');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec3_value')) {
                    $table->string('spec3_value', 255)->nullable()->after('spec3_badge');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec3_unit')) {
                    $table->string('spec3_unit', 255)->nullable()->after('spec3_value');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec3_desc')) {
                    $table->string('spec3_desc', 255)->nullable()->after('spec3_unit');
                }

                // Stat 4
                if (!Schema::hasColumn('product_descriptions', 'spec4_icon')) {
                    $table->string('spec4_icon', 255)->nullable()->after('spec3_desc');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec4_badge')) {
                    $table->string('spec4_badge', 255)->nullable()->after('spec4_icon');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec4_value')) {
                    $table->string('spec4_value', 255)->nullable()->after('spec4_badge');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec4_unit')) {
                    $table->string('spec4_unit', 255)->nullable()->after('spec4_value');
                }
                if (!Schema::hasColumn('product_descriptions', 'spec4_desc')) {
                    $table->string('spec4_desc', 255)->nullable()->after('spec4_unit');
                }
            });
        }

        // Copy SPECIFICATIONS.png into storage
        $targetDir = storage_path('app/public/products');
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }
        $srcSpec = public_path('themes/default/assets/img/products/SPECIFICATIONS.png');
        $destSpec = $targetDir . '/specifications.png';
        if (File::exists($srcSpec) && !File::exists($destSpec)) {
            File::copy($srcSpec, $destSpec);
        }

        // Also public/storage if direct directory
        $publicDest = public_path('storage/products/specifications.png');
        if (File::exists(public_path('storage')) && !is_link(public_path('storage')) && File::exists($srcSpec) && !File::exists($publicDest)) {
            File::copy($srcSpec, $publicDest);
        }

        // Update default specs_image in DB
        if (Schema::hasTable('product_descriptions') && Schema::hasColumn('product_descriptions', 'specs_image')) {
            DB::table('product_descriptions')
                ->whereNull('specs_image')
                ->orWhere('specs_image', '')
                ->update(['specs_image' => 'products/specifications.png']);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('product_descriptions')) {
            Schema::table('product_descriptions', function (Blueprint $table) {
                $columns = [
                    'specs_badge', 'specs_title', 'specs_description', 'specs_image',
                    'spec1_icon', 'spec1_badge', 'spec1_value', 'spec1_unit', 'spec1_desc',
                    'spec2_icon', 'spec2_badge', 'spec2_value', 'spec2_unit', 'spec2_desc',
                    'spec3_icon', 'spec3_badge', 'spec3_value', 'spec3_unit', 'spec3_desc',
                    'spec4_icon', 'spec4_badge', 'spec4_value', 'spec4_unit', 'spec4_desc',
                ];
                foreach ($columns as $col) {
                    if (Schema::hasColumn('product_descriptions', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
