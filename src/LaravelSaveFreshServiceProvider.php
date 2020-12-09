<?php

namespace Iamamirsalehi\LaravelSaveFresh;

use Illuminate\Support\ServiceProvider;

class LaravelSaveFreshServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'iamamirsalehi');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'iamamirsalehi');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-save-fresh.php', 'laravel-save-fresh');

        // Register the service the package provides.
        $this->app->singleton('laravel-save-fresh', function ($app) {
            return new LaravelSaveFresh;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-save-fresh'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravel-save-fresh.php' => config_path('laravel-save-fresh.php'),
        ], 'laravel-save-fresh.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/iamamirsalehi'),
        ], 'laravel-save-fresh.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/iamamirsalehi'),
        ], 'laravel-save-fresh.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/iamamirsalehi'),
        ], 'laravel-save-fresh.views');*/

        // Registering package commands.
         $this->commands([
             \Iamamirsalehi\LaravelSaveFresh\Console\Commands\LaravelSaveFresh::class,
             \Iamamirsalehi\LaravelSaveFresh\Console\Commands\RestoreDatabaseCommand::class
         ]);
    }
}
