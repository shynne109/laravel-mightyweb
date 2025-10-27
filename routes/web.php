<?php

use Illuminate\Support\Facades\Route;
use MightyWeb\Http\Controllers\DashboardController;
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
        Route::get('/', function () {
            return view('mightyweb::pages.dashboard');
        })->name('dashboard');
        
        // Legacy individual routes (for backward compatibility)
        // App Configuration
        Route::get('/configuration', function () {
            return view('mightyweb::pages.configuration');
        })->name('configuration');
        
        // Walkthrough
        Route::get('/walkthrough', function () {
            return view('mightyweb::pages.walkthrough.index');
        })->name('walkthrough.index');
        
        Route::get('/walkthrough/create', function () {
            return view('mightyweb::pages.walkthrough.create');
        })->name('walkthrough.create');
        
        Route::get('/walkthrough/{id}/edit', function ($id) {
            return view('mightyweb::pages.walkthrough.edit', ['id' => $id]);
        })->name('walkthrough.edit');
        
        // Menu
        Route::get('/menu', function () {
            return view('mightyweb::pages.menu.index');
        })->name('menu.index');
        
        Route::get('/menu/create', function () {
            return view('mightyweb::pages.menu.create');
        })->name('menu.create');
        
        Route::get('/menu/{id}/edit', function ($id) {
            return view('mightyweb::pages.menu.edit', ['id' => $id]);
        })->name('menu.edit');
        
        // Navigation Icons
        Route::get('/navigation-icons/left', function () {
            return view('mightyweb::pages.navigation-icons.left');
        })->name('navigation-icons.left');
        
        Route::get('/navigation-icons/right', function () {
            return view('mightyweb::pages.navigation-icons.right');
        })->name('navigation-icons.right');
        
        // Tabs
        Route::get('/tabs', function () {
            return view('mightyweb::pages.tabs.index');
        })->name('tabs.index');
        
        Route::get('/tabs/create', function () {
            return view('mightyweb::pages.tabs.create');
        })->name('tabs.create');
        
        Route::get('/tabs/{id}/edit', function ($id) {
            return view('mightyweb::pages.tabs.edit', ['id' => $id]);
        })->name('tabs.edit');
        
        // Pages
        Route::get('/pages', function () {
            return view('mightyweb::pages.pages.index');
        })->name('pages.index');
        
        Route::get('/pages/create', function () {
            return view('mightyweb::pages.pages.create');
        })->name('pages.create');
        
        Route::get('/pages/{id}/edit', function ($id) {
            return view('mightyweb::pages.pages.edit', ['id' => $id]);
        })->name('pages.edit');
        
        // Theme
        Route::get('/theme', function () {
            return view('mightyweb::pages.theme');
        })->name('theme');
        
        // Splash Screen
        Route::get('/splash', function () {
            return view('mightyweb::pages.splash');
        })->name('splash');
        
        // AdMob
        Route::get('/admob', function () {
            return view('mightyweb::pages.admob');
        })->name('admob');
        
        // OneSignal
        Route::get('/onesignal', function () {
            return view('mightyweb::pages.onesignal');
        })->name('onesignal');
        
        // Progress Bar
        Route::get('/progress-bar', function () {
            return view('mightyweb::pages.progress-bar');
        })->name('progress-bar');
        
        // Exit Popup
        Route::get('/exit-popup', function () {
            return view('mightyweb::pages.exit-popup');
        })->name('exit-popup');
        
        // Floating Button
        Route::get('/floating-button', function () {
            return view('mightyweb::pages.floating-button');
        })->name('floating-button');
        
        // Share
        Route::get('/share', function () {
            return view('mightyweb::pages.share');
        })->name('share');
        
        // About
        Route::get('/about', function () {
            return view('mightyweb::pages.about');
        })->name('about');
        
        // User Agent
        Route::get('/user-agent', function () {
            return view('mightyweb::pages.user-agent');
        })->name('user-agent');
        
        // JSON Export
        Route::post('/export-json', [JsonExportController::class, 'export'])->name('json.export');
        Route::get('/download-json', [JsonExportController::class, 'download'])->name('json.download');
    });
