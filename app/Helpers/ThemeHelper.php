<?php

if (!function_exists('active_theme')) {
    /**
     * Get the active theme name.
     *
     * @return string
     */
    function active_theme(): string
    {
        return config('theme.active', 'default');
    }
}

if (!function_exists('theme_asset')) {
    /**
     * Get the URL for a theme asset.
     *
     * @param string $path
     * @param string|null $theme
     * @return string
     */
    function theme_asset(string $path, ?string $theme = null): string
    {
        $theme = $theme ?: active_theme();
        $cleanPath = ltrim($path, '/');
        return asset("themes/{$theme}/assets/{$cleanPath}");
    }
}

if (!function_exists('theme_view')) {
    /**
     * Get the evaluated view contents for a theme view.
     *
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @return \Illuminate\Contracts\View\View
     */
    function theme_view(string $view, array $data = [], array $mergeData = [])
    {
        $theme = active_theme();
        $fallback = config('theme.fallback', 'default');

        $activeViewName = "themes.{$theme}.{$view}";
        if (view()->exists($activeViewName)) {
            return view($activeViewName, $data, $mergeData);
        }

        $fallbackViewName = "themes.{$fallback}.{$view}";
        if (view()->exists($fallbackViewName)) {
            return view($fallbackViewName, $data, $mergeData);
        }

        return view($view, $data, $mergeData);
    }
}

if (!function_exists('theme_css')) {
    /**
     * Render the theme CSS link tags.
     * In local / debug mode, outputs individual unminified CSS files with auto filemtime for seamless development.
     * In production, outputs the consolidated minified bundle with filemtime cache-busting.
     *
     * @param string|null $theme
     * @return \Illuminate\Support\HtmlString
     */
    function theme_css(?string $theme = null): \Illuminate\Support\HtmlString
    {
        $theme = $theme ?: active_theme();
        $bundleRelative = "themes/{$theme}/assets/css/theme.bundle.min.css";
        $bundlePath = public_path($bundleRelative);

        $files = [
            'css/style.css',
            'css/layout.css',
            'css/components.css',
            'css/responsive.css',
        ];

        // Track latest modified time of source files
        $latestMtime = 0;
        foreach ($files as $file) {
            $filePath = public_path("themes/{$theme}/assets/{$file}");
            if (file_exists($filePath)) {
                $latestMtime = max($latestMtime, filemtime($filePath));
            }
        }

        $bundleExists = file_exists($bundlePath);
        $bundleMtime = $bundleExists ? filemtime($bundlePath) : 0;

        // Auto-rebuild if bundle is missing or if any source file has changed
        if (!$bundleExists || $latestMtime > $bundleMtime) {
            rebuild_theme_css_bundle($theme);
            $bundleMtime = file_exists($bundlePath) ? filemtime($bundlePath) : time();
        }

        $url = asset($bundleRelative) . "?v={$bundleMtime}";
        return new \Illuminate\Support\HtmlString(
            "<link rel=\"stylesheet\" href=\"{$url}\">"
        );
    }
}

if (!function_exists('rebuild_theme_css_bundle')) {
    /**
     * Rebuild and minify theme CSS bundle from source files.
     *
     * @param string|null $theme
     * @return int Size in bytes of generated bundle
     */
    function rebuild_theme_css_bundle(?string $theme = null): int
    {
        $theme = $theme ?: active_theme();
        $baseDir = public_path("themes/{$theme}/assets/css");
        $files = [
            $baseDir . '/style.css',
            $baseDir . '/layout.css',
            $baseDir . '/components.css',
            $baseDir . '/responsive.css',
        ];

        $combined = '';
        foreach ($files as $f) {
            if (file_exists($f)) {
                $content = file_get_contents($f);
                // Strip redundant @import fonts since they are loaded in HTML head
                $content = preg_replace('/@import\s+url\([^)]+\);?/i', '', $content);
                $combined .= "\n" . $content;
            }
        }

        // Minification:
        // 1. Remove comments
        $minified = preg_replace('!/\*.*?\*/!s', '', $combined);
        // 2. Collapse whitespace
        $minified = preg_replace('/\s+/', ' ', $minified);
        // 3. Remove space around symbols
        $minified = preg_replace('/\s*([{};:,>])\s*/', '$1', $minified);
        // 4. Remove trailing semicolons before }
        $minified = preg_replace('/;}/', '}', $minified);
        $minified = trim($minified);

        $outputPath = $baseDir . '/theme.bundle.min.css';
        @file_put_contents($outputPath, $minified);

        return strlen($minified);
    }
}
