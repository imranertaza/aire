<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class JsonDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds using the JSON dump.
     */
    public function run(): void
    {
        $jsonPath = base_path('aire_main.json');
        if (!File::exists($jsonPath)) {
            $this->command?->error("aire_main.json not found at {$jsonPath}");
            return;
        }

        $this->command?->info("Loading and parsing {$jsonPath}...");

        $jsonContent = File::get($jsonPath);
        $elements = json_decode($jsonContent, true);

        if (!is_array($elements)) {
            $this->command?->error("Failed to parse aire_main.json as valid JSON.");
            return;
        }

        // 1. Disable Foreign Key Constraints
        Schema::disableForeignKeyConstraints();
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        $skippedTables = ['cache', 'cache_locks', 'failed_jobs', 'job_batches', 'jobs', 'sessions'];

        foreach ($elements as $element) {
            if (($element['type'] ?? '') !== 'table') {
                continue;
            }

            $tableName = $element['name'] ?? null;
            $data = $element['data'] ?? [];

            if (!$tableName || in_array($tableName, $skippedTables)) {
                continue;
            }

            // Check if table exists in current database schema
            if (!Schema::hasTable($tableName)) {
                $this->command?->warn("Table '{$tableName}' does not exist in schema. Skipping.");
                continue;
            }

            if (empty($data)) {
                continue;
            }

            // Clean existing table data first to guarantee 100% fresh import from JSON
            try {
                DB::table($tableName)->truncate();
            } catch (\Throwable $e) {
                DB::table($tableName)->delete();
            }

            $this->command?->info("Importing " . count($data) . " records into '{$tableName}'...");

            // Process in chunks of 100 for optimal performance
            $chunks = array_chunk($data, 100);
            foreach ($chunks as $chunk) {
                // Ensure null values or correct types
                $cleanedChunk = [];
                foreach ($chunk as $row) {
                    $cleanedRow = [];
                    foreach ($row as $col => $val) {
                        // Filter out columns that don't exist in the current table schema
                        if (Schema::hasColumn($tableName, $col)) {
                            $cleanedRow[$col] = $val;
                        }
                    }
                    if (!empty($cleanedRow)) {
                        $cleanedChunk[] = $cleanedRow;
                    }
                }

                if (!empty($cleanedChunk)) {
                    try {
                        DB::table($tableName)->insertOrIgnore($cleanedChunk);
                    } catch (\Throwable $e) {
                        // Fallback to row-by-row insertion if batch fails
                        foreach ($cleanedChunk as $singleRow) {
                            try {
                                DB::table($tableName)->insertOrIgnore([$singleRow]);
                            } catch (\Throwable $rowException) {
                                // Ignore individual duplicate/format issues
                            }
                        }
                    }
                }
            }
        }

        // 2. Re-enable Foreign Key Constraints
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        Schema::enableForeignKeyConstraints();

        // 3. Clear permission & application cache
        try {
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        } catch (\Throwable $e) {
            //
        }

        $this->command?->info("JSON Database seeding completed successfully!");
    }
}
