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
