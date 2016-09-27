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
        // merge default configs with publish configs
        $this->mergeDefaultConfig();
    }

    /**
     * merge default configs with publish configs
     */
    protected function mergeDefaultConfig()
    {
        $config = $this->app['config']->get('laravel-company-module', []);
        $default = require __DIR__.'/../config/default.php';

        $config['routes'] = $default['routes'];


        $path = unsetReturn($config['company']['uploads'],'path');
        $default['company']['uploads']['photo']['path'] = $path;
        $max_size = unsetReturn($config['company']['uploads'],'max_size');
        $default['company']['uploads']['photo']['max_size'] = $max_size;
        $default['company']['uploads']['photo']['max_file'] = unsetReturn($config['company']['uploads'],'upload_max_file');
        $aspect_ratio = unsetReturn($config['company']['uploads'],'photo_aspect_ratio');
        $default['company']['uploads']['photo']['aspect_ratio'] = $aspect_ratio;
        $mimes = unsetReturn($config['company']['uploads'],'photo_mimes');
        $default['company']['uploads']['photo']['mimes'] = $mimes;
        $thumbnails = unsetReturn($config['company']['uploads'],'photo_thumbnails');
        $default['company']['uploads']['photo']['thumbnails'] = $thumbnails;
        $config['company']['uploads']['photo'] = $default['company']['uploads']['photo'];

        $this->app['config']->set('laravel-company-module', $config);
    }
}
