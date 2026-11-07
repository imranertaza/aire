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
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('link_type', 50)->default('url')->change();

            if (!Schema::hasColumn('menu_items', 'product_category_id')) {
                $table->foreignId('product_category_id')
                    ->nullable()
                    ->after('link_type')
                    ->constrained('product_categories')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('menu_items', 'has_quick_view')) {
                $table->boolean('has_quick_view')
                    ->default(0)
                    ->after('product_category_id')
                    ->index();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            if (Schema::hasColumn('menu_items', 'has_quick_view')) {
                $table->dropIndex(['has_quick_view']);
                $table->dropColumn('has_quick_view');
            }

            if (Schema::hasColumn('menu_items', 'product_category_id')) {
                $table->dropForeign(['product_category_id']);
                $table->dropColumn('product_category_id');
            }
            $table->enum('link_type', ['page', 'category', 'url'])->default('url')->change();
        });
    }
};

