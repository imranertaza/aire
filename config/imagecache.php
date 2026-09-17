<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Image Manipulation Driver
    |--------------------------------------------------------------------------
    |
    | Supported drivers: "gd", "imagick"
    | Default is "gd", which is standard on PHP distributions.
    |
    */
    'driver' => env('IMAGE_CACHE_DRIVER', 'gd'),

    /*
    |--------------------------------------------------------------------------
    | Default Format & Quality
    |--------------------------------------------------------------------------
    |
    | Output format: "webp", "jpg", "png"
    | Quality: 1 - 100 (80 - 85 provides optimal balance of visual quality
    | and file size reduction, typically 70-85% smaller than raw files).
    |
    */
    'format' => env('IMAGE_CACHE_FORMAT', 'webp'),
    'quality' => (int) env('IMAGE_CACHE_QUALITY', 85),

    /*
    |--------------------------------------------------------------------------
    | Cache Storage Location
    |--------------------------------------------------------------------------
    |
    | The directory where cached images will be saved. Default is public/cache
    | so the web server can directly serve the static files with 0ms PHP overhead.
    |
    */
    'cache_dir' => public_path('cache'),

    /*
    |--------------------------------------------------------------------------
    | Cache Lifetime in Seconds
    |--------------------------------------------------------------------------
    |
    | Default: 30 days (2592000 seconds)
    |
    */
    'cache_lifetime' => (int) env('IMAGE_CACHE_LIFETIME', 2592000),

    /*
    |--------------------------------------------------------------------------
    | Dimensions Safeguards
    |--------------------------------------------------------------------------
    |
    | Maximum allowed width/height to prevent memory exhaustion and DoS.
    |
    */
    'max_width' => (int) env('IMAGE_CACHE_MAX_WIDTH', 3840),
    'max_height' => (int) env('IMAGE_CACHE_MAX_HEIGHT', 3840),

    /*
    |--------------------------------------------------------------------------
    | Fallback Placeholder
    |--------------------------------------------------------------------------
    */
    'fallback' => 'public/assets/images/default.png',
];
