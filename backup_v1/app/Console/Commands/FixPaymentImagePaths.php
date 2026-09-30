<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixPaymentImagePaths extends Command
{
    protected $signature   = 'payment:fix-image-paths';
    protected $description = 'Prefix bare payment method image filenames with "payment/" to match the Storage disk path.';

    public function handle(): int
    {
        $rows = DB::table('payment_methods')
            ->whereNotNull('image')
            ->get(['id', 'name', 'image']);

        $updated = 0;

        foreach ($rows as $row) {
            // Skip external URLs (http/https) and already-prefixed paths
            if (str_starts_with($row->image, 'http') || str_starts_with($row->image, 'payment/')) {
                $this->line("  <fg=gray>Skipped</> [{$row->id}] {$row->name} — already correct");
                continue;
            }

            DB::table('payment_methods')
                ->where('id', $row->id)
                ->update(['image' => 'payment/' . $row->image]);

            $this->line("  <fg=green>Updated</> [{$row->id}] {$row->name}: {$row->image} → payment/{$row->image}");
            $updated++;
        }

        $this->newLine();
        $this->info("Done. {$updated} row(s) updated.");

        return Command::SUCCESS;
    }
}
