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
        if (Schema::hasTable('filter_options')) {
            Schema::table('filter_options', function (Blueprint $table) {
                if (!Schema::hasColumn('filter_options', 'show_in_catalog')) {
                    $table->tinyInteger('show_in_catalog')->default(1)->after('show_in_filter');
                }
                if (!Schema::hasColumn('filter_options', 'show_in_guided_finder')) {
                    $table->tinyInteger('show_in_guided_finder')->default(0)->after('show_in_catalog');
                }
                if (!Schema::hasColumn('filter_options', 'guided_step_number')) {
                    $table->integer('guided_step_number')->nullable()->after('show_in_guided_finder');
                }
                if (!Schema::hasColumn('filter_options', 'guided_question')) {
                    $table->string('guided_question', 255)->nullable()->after('guided_step_number');
                }
                if (!Schema::hasColumn('filter_options', 'guided_subtitle')) {
                    $table->string('guided_subtitle', 255)->nullable()->after('guided_question');
                }
                if (!Schema::hasColumn('filter_options', 'has_unknown_option')) {
                    $table->tinyInteger('has_unknown_option')->default(1)->after('guided_subtitle');
                }
                if (!Schema::hasColumn('filter_options', 'unknown_option_label')) {
                    $table->string('unknown_option_label', 100)->nullable()->default("I don't know")->after('has_unknown_option');
                }
            });

            // Sync show_in_catalog from existing show_in_filter
            DB::statement('UPDATE filter_options SET show_in_catalog = show_in_filter WHERE show_in_catalog IS NULL OR show_in_catalog = 1');
        }

        if (Schema::hasTable('filter_option_values')) {
            Schema::table('filter_option_values', function (Blueprint $table) {
                if (!Schema::hasColumn('filter_option_values', 'explanation')) {
                    $table->text('explanation')->nullable()->after('name');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('filter_options')) {
            Schema::table('filter_options', function (Blueprint $table) {
                $columns = [
                    'show_in_catalog',
                    'show_in_guided_finder',
                    'guided_step_number',
                    'guided_question',
                    'guided_subtitle',
                    'has_unknown_option',
                    'unknown_option_label',
                ];
                foreach ($columns as $col) {
                    if (Schema::hasColumn('filter_options', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('filter_option_values')) {
            Schema::table('filter_option_values', function (Blueprint $table) {
                if (Schema::hasColumn('filter_option_values', 'explanation')) {
                    $table->dropColumn('explanation');
                }
            });
        }
    }
};

