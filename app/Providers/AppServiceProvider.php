<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        require_once app_path('Helpers/ThemeHelper.php');

        $settings = $settings = Setting::allCached();
        View::share('settings', $settings);

        // Share Active Theme & Add Theme View Path
        $activeTheme = config('theme.active', 'default');
        View::share('activeTheme', $activeTheme);
        
        $themeViewPath = resource_path("views/themes/{$activeTheme}");
        if (is_dir($themeViewPath)) {
            View::addLocation($themeViewPath);
        }

        // Auto-copy assets for default theme if public/themes/default/assets doesn't exist
        $publicAssetsPath = public_path("themes/{$activeTheme}/assets");
        $templateAssetsPath = base_path('aire-html-template/assets');
        if (!is_dir($publicAssetsPath) && is_dir($templateAssetsPath)) {
            $copyHelper = function ($src, $dst) use (&$copyHelper) {
                $dir = opendir($src);
                @mkdir($dst, 0777, true);
                while (false !== ($file = readdir($dir))) {
                    if (($file != '.') && ($file != '..')) {
                        if (is_dir($src . '/' . $file)) {
                            $copyHelper($src . '/' . $file, $dst . '/' . $file);
                        } else {
                            copy($src . '/' . $file, $dst . '/' . $file);
                        }
                    }
                }
                closedir($dir);
            };
            $copyHelper($templateAssetsPath, $publicAssetsPath);
        }

        \Illuminate\Pagination\Paginator::useBootstrapFive();

        Auth::provider('cached', function ($app, array $config) {
            return new \App\Providers\CachedUserProvider($app['hash'], $config['model']);
        });
    }
}
