<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Active Theme
    |--------------------------------------------------------------------------
    |
    | This value dictates the active storefront theme used by the application.
    | The default theme corresponds to the 'default' theme folder in
    | resources/views/themes/default and public/themes/default.
    |
    */

    'active' => env('ACTIVE_THEME', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Fallback Theme
    |--------------------------------------------------------------------------
    |
    | If a view or asset is missing in the active theme, the application
    | will fall back to this theme.
    |
    */

    'fallback' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Available Themes
    |--------------------------------------------------------------------------
    |
    | Registered themes in the application with metadata.
    |
    */

    'themes' => [
        'default' => [
            'name' => 'AIRE Default Theme',
            'author' => 'AIRE Team',
            'view_path' => 'themes/default',
            'asset_path' => 'themes/default/assets',
        ],
    ],

];
