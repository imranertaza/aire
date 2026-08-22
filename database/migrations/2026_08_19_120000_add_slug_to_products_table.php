<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'slug')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('slug', 255)->nullable()->after('name');
            });
        }

        // Generate slugs for existing products
        $products = DB::table('products')->select('id', 'name', 'model')->get();
        $slugs = [];

        foreach ($products as $product) {
            $baseSlug = Str::slug($product->name);
            if (empty($baseSlug)) {
                $baseSlug = Str::slug($product->model) ?: 'product-' . $product->id;
            }

            $slug = $baseSlug;
            $counter = 1;
            while (in_array($slug, $slugs) || DB::table('products')->where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $slugs[] = $slug;
            DB::table('products')->where('id', $product->id)->update(['slug' => $slug]);
        }

        // Set slug column to NOT NULL and UNIQUE
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug', 255)->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'slug')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
