<?php

namespace ErenMustafaOzdal\LaravelCompanyModule;

use Illuminate\Support\ServiceProvider;

class LaravelCompanyModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../config/laravel-company-module.php' => config_path('laravel-company-module.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('ErenMustafaOzdal\LaravelModulesBase\LaravelModulesBaseServiceProvider');
        $this->app->register('Mews\Purifier\PurifierServiceProvider');

        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-company-module.php', 'laravel-company-module'
        );
    }
}
