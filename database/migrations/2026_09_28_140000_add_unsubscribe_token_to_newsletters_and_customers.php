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
        // 1. Add unsubscribe columns to newsletters table
        if (Schema::hasTable('newsletters')) {
            Schema::table('newsletters', function (Blueprint $table) {
                if (!Schema::hasColumn('newsletters', 'unsubscribe_token')) {
                    $table->string('unsubscribe_token', 64)->nullable()->unique()->after('status');
                }
                if (!Schema::hasColumn('newsletters', 'unsubscribed_at')) {
                    $table->timestamp('unsubscribed_at')->nullable()->after('unsubscribe_token');
                }
            });
        }

        // 2. Add marketing subscription columns to customers table
        if (Schema::hasTable('customers')) {
            Schema::table('customers', function (Blueprint $table) {
                if (!Schema::hasColumn('customers', 'is_subscribed')) {
                    $table->boolean('is_subscribed')->default(true)->after('status');
                }
                if (!Schema::hasColumn('customers', 'unsubscribe_token')) {
                    $table->string('unsubscribe_token', 64)->nullable()->unique()->after('is_subscribed');
                }
                if (!Schema::hasColumn('customers', 'unsubscribed_at')) {
                    $table->timestamp('unsubscribed_at')->nullable()->after('unsubscribe_token');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('newsletters')) {
            Schema::table('newsletters', function (Blueprint $table) {
                if (Schema::hasColumn('newsletters', 'unsubscribed_at')) {
                    $table->dropColumn('unsubscribed_at');
                }
                if (Schema::hasColumn('newsletters', 'unsubscribe_token')) {
                    $table->dropColumn('unsubscribe_token');
                }
            });
        }

        if (Schema::hasTable('customers')) {
            Schema::table('customers', function (Blueprint $table) {
                if (Schema::hasColumn('customers', 'unsubscribed_at')) {
                    $table->dropColumn('unsubscribed_at');
                }
                if (Schema::hasColumn('customers', 'unsubscribe_token')) {
                    $table->dropColumn('unsubscribe_token');
                }
                if (Schema::hasColumn('customers', 'is_subscribed')) {
                    $table->dropColumn('is_subscribed');
                }
            });
        }
    }
};
