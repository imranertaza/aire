<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE category_featured_products MODIFY COLUMN position VARCHAR(20) NOT NULL DEFAULT 'top'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE category_featured_products MODIFY COLUMN position ENUM('top', 'bottom') NOT NULL DEFAULT 'top'");
    }
};
