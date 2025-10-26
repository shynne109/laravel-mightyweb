<?php

use Illuminate\Support\Facades\Route;
use MightyWeb\Http\Controllers\Api\ConfigController;

/*
|--------------------------------------------------------------------------
| MightyWeb API Routes
|--------------------------------------------------------------------------
|
| Here are the API routes for mobile app consumption.
| These routes provide JSON configuration and public asset access.
|
*/

$apiConfig = config('mightyweb.api', [
    'prefix' => 'api/mightyweb',
    'middleware' => ['api'],
]);

Route::prefix($apiConfig['prefix'])
    ->middleware($apiConfig['middleware'])
    ->group(function () {
        
        // Get full app configuration as JSON
        Route::get('/config', [ConfigController::class, 'index'])->name('api.config');
        
        // Get specific configuration sections
        Route::get('/config/app-settings', [ConfigController::class, 'appSettings'])->name('api.config.app-settings');
        Route::get('/config/walkthrough', [ConfigController::class, 'walkthrough'])->name('api.config.walkthrough');
        Route::get('/config/menu', [ConfigController::class, 'menu'])->name('api.config.menu');
        Route::get('/config/tabs', [ConfigController::class, 'tabs'])->name('api.config.tabs');
        Route::get('/config/pages', [ConfigController::class, 'pages'])->name('api.config.pages');
        Route::get('/config/theme', [ConfigController::class, 'theme'])->name('api.config.theme');
        
        // Health check
        Route::get('/health', function () {
            return response()->json([
                'status' => 'ok',
                'package' => 'mightyweb',
                'version' => '1.0.0',
                'timestamp' => now()->toIso8601String(),
            ]);
        })->name('api.health');
    });
