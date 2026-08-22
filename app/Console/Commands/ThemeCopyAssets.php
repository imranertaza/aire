<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ThemeCopyAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:copy-assets {theme=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy template assets to public theme directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $theme = $this->argument('theme');
        $src = base_path('aire-html-template/assets');
        $dst = public_path("themes/{$theme}/assets");

        if (!is_dir($src)) {
            $this->error("Source template directory [{$src}] does not exist.");
            return 1;
        }

        $this->copyDirectory($src, $dst);
        $this->info("Assets copied successfully for theme [{$theme}] to [{$dst}].");
        return 0;
    }

    private function copyDirectory($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst, 0777, true);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->copyDirectory($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
