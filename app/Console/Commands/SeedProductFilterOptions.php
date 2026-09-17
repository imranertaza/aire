<?php

namespace App\Console\Commands;

use Database\Seeders\ProductFilterOptionSeeder;
use Illuminate\Console\Command;

class SeedProductFilterOptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:set-filter-options';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set and assign filter options to all products in the database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Assigning filter options to all products...');
        
        $seeder = new ProductFilterOptionSeeder();
        $seeder->setCommand($this);
        $seeder->run();

        \Illuminate\Support\Facades\Cache::forget('all_filter_options');
        $this->info('Done! All products have filter options assigned.');

        return Command::SUCCESS;
    }
}
