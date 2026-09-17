<?php

namespace App\Console\Commands;

use App\Services\ImageService;
use Illuminate\Console\Command;

class ClearImageCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:clear-cache {--prune= : Prune images older than specified number of days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear or prune cached and optimized images';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $pruneDays = $this->option('prune');

        if ($pruneDays !== null) {
            $days = (int) $pruneDays;
            $this->info("Pruning cached images older than {$days} days...");
            $deleted = ImageService::pruneCache($days);
            $this->info("Successfully pruned {$deleted} cached image(s).");
            return Command::SUCCESS;
        }

        $this->info('Clearing all cached images...');
        $deleted = ImageService::clearCache();
        $this->info("Successfully cleared {$deleted} cached image(s) and flushed image cache keys.");

        return Command::SUCCESS;
    }
}
