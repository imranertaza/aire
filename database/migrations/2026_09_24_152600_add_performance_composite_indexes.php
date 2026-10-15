<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration adds high-performance composite indexes to optimize:
     * 1. Multi-faceted AJAX filter lookups (whereIn option value queries).
     * 2. Active catalog product retrieval and sorting without memory filesort.
     * 3. Category product pivot joins with 100% covering index scans.
     */
    public function up(): void
    {
        // 1. PRODUCT_FILTER_OPTIONS TABLE
        try {
            Schema::table('product_filter_options', function (Blueprint $table) {
                $table->index(['filter_option_value_id', 'product_id'], 'idx_pfo_val_prod');
            });
        } catch (\Throwable $e) {}

        try {
            Schema::table('product_filter_options', function (Blueprint $table) {
                $table->index(['product_id', 'filter_option_value_id'], 'idx_pfo_prod_val');
            });
        } catch (\Throwable $e) {}

        // 2. PRODUCTS TABLE
        try {
            Schema::table('products', function (Blueprint $table) {
                $table->index(['status', 'featured', 'id'], 'idx_products_status_featured_id');
            });
        } catch (\Throwable $e) {}

        try {
            Schema::table('products', function (Blueprint $table) {
                $table->index(['status', 'sort_order', 'id'], 'idx_products_status_sort_id');
            });
        } catch (\Throwable $e) {}

        try {
            Schema::table('products', function (Blueprint $table) {
                $table->index(['status', 'price'], 'idx_products_status_price');
            });
        } catch (\Throwable $e) {}

        // 3. PRODUCT_TO_CATEGORIES PIVOT TABLE
        try {
            Schema::table('product_to_categories', function (Blueprint $table) {
                $table->index(['category_id', 'product_id'], 'idx_p2c_category_product');
            });
        } catch (\Throwable $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_to_categories', function (Blueprint $table) {
            $table->dropIndex('idx_p2c_category_product');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_status_featured_id');
            $table->dropIndex('idx_products_status_sort_id');
            $table->dropIndex('idx_products_status_price');
        });

        Schema::table('product_filter_options', function (Blueprint $table) {
            $table->dropIndex('idx_pfo_val_prod');
            $table->dropIndex('idx_pfo_prod_val');
        });
    }
};
