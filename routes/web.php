<?php

use Illuminate\Support\Facades\Route;
use MightyWeb\Http\Controllers\JsonExportController;

/*
|--------------------------------------------------------------------------
| MightyWeb Web Routes
|--------------------------------------------------------------------------
|
| Here are the web routes for the MightyWeb admin panel.
| These routes are loaded by the MightyWebServiceProvider and assigned
| the middleware and prefix specified in config/mightyweb.php
|
| Components are routed using Livewire 4's Route::livewire() macro
| which renders Single File Components (SFC) as full-page components.
|
*/

$routeConfig = config('mightyweb.route', [
    'prefix' => 'mightyweb',
    'middleware' => ['web', 'auth'],
    'name_prefix' => 'mightyweb.',
]);

Route::prefix($routeConfig['prefix'])
    ->middleware($routeConfig['middleware'])
    ->name($routeConfig['name_prefix'])
    ->group(function () {

        // Unified Dashboard - All modules in one tabbed interface
        Route::livewire('/', 'mightyweb::index')->name('dashboard');

        // JSON Export
        Route::post('/export-json', [JsonExportController::class, 'export'])->name('json.export');
        Route::get('/download-json', [JsonExportController::class, 'download'])->name('json.download');
    });
