<?php

namespace MightyWeb;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

/**
 * MightyWeb Service Provider
 *
 * @version 1.1.0
 *
 * MightyWeb is a Laravel package for managing mobile app configurations
 * with Livewire 4 Single File Components (SFC), Livewire Flux UI, and Tailwind CSS styling.
 *
 * Features:
 * - Livewire 4 Single File Components (SFC) with modal CRUD
 * - Livewire Flux professional UI components (WCAG 2.1 AA compliant)
 * - 8 core modules for app configuration management
 * - Vite-powered asset compilation with automatic cache busting
 * - Dark mode support throughout
 * - Responsive design with Tailwind CSS 4
 *
 * Usage:
 * - Add @mightywebAssets to <head> section (includes Flux appearance)
 * - Add @mightywebScripts before </body> (includes Flux scripts)
 */
class MightyWebServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge package config with application config
        $this->mergeConfigFrom(
            __DIR__.'/../config/mightyweb.php', 'mightyweb'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load package routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        // Load package views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mightyweb');

        // Load package migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Register SFC components namespace for auto-discovery (Livewire 4 native SFC)
        // Components are invoked as <livewire:mightyweb::component-name />
        Livewire::addNamespace(
            namespace: 'mightyweb',
            viewPath: __DIR__.'/../resources/views',
        );

        // Publish configuration file
        $this->publishes([
            __DIR__.'/../config/mightyweb.php' => config_path('mightyweb.php'),
        ], 'mightyweb-config');

        // Publish migrations
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'mightyweb-migrations');

        // Publish views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/livewire/mightyweb'),
        ], 'mightyweb-views');

        // Publish public assets (pre-built CSS/JS)
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/mightyweb'),
        ], 'mightyweb-assets');

        // Register Livewire components
        $this->registerLivewireComponents();

        // Register Blade directives for asset injection
        $this->registerBladeDirectives();

        // Register commands if running in console
        if ($this->app->runningInConsole()) {
            // Future: Register artisan commands here
        }
    }

    /**
     * Register Blade directives for automatic asset injection.
     */
    protected function registerBladeDirectives(): void
    {
        // Directive for injecting CSS and header assets (includes Flux appearance)
        Blade::directive('mightywebAssets', function () {
            return "<?php echo view('mightyweb::layouts.assets')->render(); ?>";
        });

        // Directive for injecting JavaScript and footer scripts (includes Flux scripts)
        Blade::directive('mightywebScripts', function () {
            return "<?php echo view('mightyweb::layouts.scripts')->render(); ?>";
        });
    }

    /**
     * Register Livewire Single File Components.
     *
     * SFC components are auto-discovered via the 'mightyweb' namespace
     * registered in boot(). This method is kept for any future explicit
     * component registrations.
     */
    protected function registerLivewireComponents(): void
    {
        // SFC components are auto-discovered from:
        // - resources/views/floating-button/index.blade.php
        // - resources/views/tab/index.blade.php
        // - resources/views/navigation-icon/index.blade.php
        // - resources/views/walkthrough/index.blade.php
        // - resources/views/menu/index.blade.php
        // - resources/views/page/index.blade.php
        // - resources/views/theme/configuration.blade.php
        // - resources/views/app-configuration.blade.php
        // - resources/views/notification/index.blade.php
    }
}
