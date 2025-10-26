<?php

namespace MightyWeb;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Livewire\Volt\Volt;

/**
 * MightyWeb Service Provider
 * 
 * @package MightyWeb
 * @version 1.1.0
 * 
 * MightyWeb is a Laravel package for managing mobile app configurations
 * with a modern Livewire Volt architecture, Livewire Flux UI, and Tailwind CSS styling.
 * 
 * Features:
 * - Livewire Volt class-based components with modal CRUD
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
        
        // Register Volt components path for auto-discovery
        if (class_exists(\Livewire\Volt\Volt::class)) {
            \Livewire\Volt\Volt::mount([
                __DIR__.'/../resources/views/livewire'
            ]);
        }

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
            __DIR__.'/../resources/views' => resource_path('views/vendor/mightyweb'),
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
        
        // Register Flux directives as aliases for convenience
        Blade::directive('fluxAppearance', function () {
            return "<?php echo \Livewire\Flux\Flux::appearance(); ?>";
        });
        
        Blade::directive('fluxScripts', function () {
            return "<?php echo \Livewire\Flux\Flux::scripts(); ?>";
        });
    }

    /**
     * Register Livewire Volt components.
     * 
     * Note: All components have been migrated to Volt class-based architecture (v2.1.0).
     * Volt components are automatically discovered from view files, so no manual 
     * registration is needed. This method is kept for backwards compatibility and
     * for any future non-Volt components.
     */
    protected function registerLivewireComponents(): void
    {
        // Volt components are auto-discovered from:
        // - resources/views/livewire/floating-button/index.blade.php
        // - resources/views/livewire/tab/index.blade.php
        // - resources/views/livewire/navigation-icon/index.blade.php
        // - resources/views/livewire/walkthrough/index.blade.php
        // - resources/views/livewire/menu/index.blade.php
        // - resources/views/livewire/page/index.blade.php
        // - resources/views/livewire/theme/configuration.blade.php
        // - resources/views/livewire/app-configuration.blade.php
        
        // All CRUD operations are now modal-based within single Volt components.
        // No separate create/edit components needed.
        
        // If you need to add non-Volt Livewire components, register them here:
        // Livewire::component('mightyweb.custom-component', CustomComponent::class);
    }
}
