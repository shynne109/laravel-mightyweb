<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database Connection
    |--------------------------------------------------------------------------
    |
    | This option controls the database connection used by MightyWeb package.
    | Set to null to use the default connection, or specify a connection name
    | defined in your database.php config file.
    |
    | Examples:
    | - null (use parent app's default connection)
    | - 'mightyweb' (use separate connection for MightyWeb)
    |
    */

    'database' => [
        'connection' => env('MIGHTYWEB_DB_CONNECTION', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the routing for the MightyWeb admin panel.
    |
    */

    'route' => [
        'prefix' => env('MIGHTYWEB_ROUTE_PREFIX', 'mightyweb'),
        'middleware' => ['web', 'auth'],
        'name_prefix' => 'mightyweb.',
    ],

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the API endpoints for mobile app consumption.
    |
    */

    'api' => [
        'prefix' => env('MIGHTYWEB_API_PREFIX', 'config'),
        'middleware' => ['api'],
        'rate_limit' => env('MIGHTYWEB_API_RATE_LIMIT', 60),
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage Configuration
    |--------------------------------------------------------------------------
    |
    | Configure where uploaded files (icons, images, etc.) are stored.
    |
    */

    'storage' => [
        'disk' => env('MIGHTYWEB_STORAGE_DISK', 'public'),
        'path' => env('MIGHTYWEB_STORAGE_PATH', 'mightyweb'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Image Processing
    |--------------------------------------------------------------------------
    |
    | Configure image optimization and processing options.
    |
    */

    'images' => [
        'optimize' => env('MIGHTYWEB_IMAGE_OPTIMIZE', true),
        'max_width' => env('MIGHTYWEB_IMAGE_MAX_WIDTH', 2000),
        'max_height' => env('MIGHTYWEB_IMAGE_MAX_HEIGHT', 2000),
        'quality' => env('MIGHTYWEB_IMAGE_QUALITY', 85),
    ],

    /*
    |--------------------------------------------------------------------------
    | JSON Export Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the JSON configuration file export settings.
    |
    */

    'json_export' => [
        'disk' => env('MIGHTYWEB_JSON_DISK', 'public'),
        'path' => env('MIGHTYWEB_JSON_PATH', 'mightyweb'),
        'filename' => env('MIGHTYWEB_JSON_FILENAME', 'mightyweb.json'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default App Settings
    |--------------------------------------------------------------------------
    |
    | Default values for app configuration settings.
    |
    */

    'defaults' => [
        'app_name' => 'MightyWeb App',
        'theme' => 'light',
        'primary_color' => '#007bff',
        'rtl' => false,
        'navigation_style' => 'bottom',
        'tab_style' => 'simple',
        'walkthrough_style' => 'style_1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Feature Toggles
    |--------------------------------------------------------------------------
    |
    | Enable or disable specific features of the package.
    |
    */

    'features' => [
        'walkthrough' => true,
        'menu' => true,
        'tabs' => true,
        'pages' => true,
        'admob' => true,
        'onesignal' => true,
        'exit_popup' => true,
        'floating_button' => true,
        'share' => true,
        'about' => true,
        'user_agent' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    |
    | Default validation rules for various inputs.
    |
    */

    'validation' => [
        'max_file_size' => 5120, // KB (5MB)
        'allowed_image_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'max_menu_depth' => 3,
        'max_tabs' => 5,
        'max_walkthroughs' => 10,
    ],

];
