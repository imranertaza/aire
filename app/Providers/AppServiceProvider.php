<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('path.public', function () {
            return base_path('public_html');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $settings = Setting::allCached();
        View::share('settings', $settings);

        // Lazy-load dynamic SMTP configuration ONLY when an email is being sent
        $this->app->resolving('mail.manager', function () {
            $settings = Setting::allCached();
            if (!empty($settings['mail_protocol']) && $settings['mail_protocol'] === 'smtp' && !empty($settings['smtp_host'])) {
                $scheme = null;
                if (($settings['smtp_crypto'] ?? '') === 'ssl') {
                    $scheme = 'smtps';
                }
                config([
                    'mail.default' => 'smtp',
                    'mail.mailers.smtp.transport' => 'smtp',
                    'mail.mailers.smtp.host' => $settings['smtp_host'],
                    'mail.mailers.smtp.port' => (int) ($settings['smtp_port'] ?? 465),
                    'mail.mailers.smtp.encryption' => ($settings['smtp_crypto'] ?? 'ssl') ?: null,
                    'mail.mailers.smtp.scheme' => $scheme,
                    'mail.mailers.smtp.username' => $settings['smtp_username'] ?? null,
                    'mail.mailers.smtp.password' => $settings['smtp_password'] ?? null,
                    'mail.mailers.smtp.timeout' => (int) ($settings['smtp_timeout'] ?? 60),
                    'mail.from.address' => $settings['send_from'] ?? ($settings['mail_address'] ?? ($settings['email'] ?? config('mail.from.address'))),
                    'mail.from.name' => $settings['brand_name'] ?? ($settings['store_name'] ?? config('app.name')),
                ]);
            }
        });

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
