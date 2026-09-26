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
        // =========================================================================
        // 1. PRODUCT_FILTER_OPTIONS TABLE
        // =========================================================================
        Schema::table('product_filter_options', function (Blueprint $table) {
            /**
             * idx_pfo_val_prod: (filter_option_value_id, product_id)
             * - Purpose: 100% Covering Index for catalog faceted filter queries.
             * - Query: $q->whereHas('productFilterOptions', fn($fq) => $fq->whereIn('filter_option_value_id', $valIds))
             * - Why needed: The existing 3-column index had filter_option_value_id at the end, forcing
             *   full row scans. This index lets MySQL fetch matching product_ids directly from the
             *   RAM B-Tree index without reading table data pages from disk.
             */
            $table->index(['filter_option_value_id', 'product_id'], 'idx_pfo_val_prod');

            /**
             * idx_pfo_prod_val: (product_id, filter_option_value_id)
             * - Purpose: Fast forward lookup to check filter option existence for a specific product.
             * - Query: Verifying or fetching options assigned to a product during catalog hydration.
             */
            $table->index(['product_id', 'filter_option_value_id'], 'idx_pfo_prod_val');
        });

        // =========================================================================
        // 2. PRODUCTS TABLE
        // =========================================================================
        Schema::table('products', function (Blueprint $table) {
            /**
             * idx_products_status_featured_id: (status, featured, id)
             * - Purpose: Eliminates MySQL "Using filesort" on featured product lookups.
             * - Query: Product::where('status', 1)->where('featured', 1)->latest('id')->limit(3)
             * - Why needed: Single indexes on (status) and (featured) forced MySQL to scan one
             *   and perform a memory/disk filesort for the ORDER BY id DESC. This composite index
             *   serves the filter and ordering simultaneously in a single B-Tree traversal.
             */
            $table->index(['status', 'featured', 'id'], 'idx_products_status_featured_id');

            /**
             * idx_products_status_sort_id: (status, sort_order, id)
             * - Purpose: Instant retrieval for default catalog product listing & pagination.
             * - Query: Product::where('status', 1)->orderBy('sort_order', 'asc')->latest('id')
             * - Why needed: Avoids temporary tables and filesort when paginating active products.
             */
            $table->index(['status', 'sort_order', 'id'], 'idx_products_status_sort_id');

            /**
             * idx_products_status_price: (status, price)
             * - Purpose: Fast range scanning and sorting for budget/price filter requests.
             * - Query: Product::where('status', 1)->whereBetween('price', [$min, $max])->orderBy('price')
             * - Why needed: Filters only active products within price boundaries without scanning
             *   inactive products or sorting in memory.
             */
            $table->index(['status', 'price'], 'idx_products_status_price');
        });

        // =========================================================================
        // 3. PRODUCT_TO_CATEGORIES PIVOT TABLE
        // =========================================================================
        Schema::table('product_to_categories', function (Blueprint $table) {
            /**
             * idx_p2c_category_product: (category_id, product_id)
             * - Purpose: Covering index for category-based product joins and filtering.
             * - Query: $query->whereHas('categories', fn($q) => $q->whereIn('id', $catIds))
             * - Why needed: The table only had individual foreign keys. Combining (category_id, product_id)
             *   allows MySQL to satisfy the category-to-product join strictly in index RAM.
             */
            $table->index(['category_id', 'product_id'], 'idx_p2c_category_product');
        });
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
