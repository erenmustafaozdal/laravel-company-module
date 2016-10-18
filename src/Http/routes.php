<?php
//max level nested function 100 hatasını düzeltiyor
ini_set('xdebug.max_nesting_level', 300);

/*
|--------------------------------------------------------------------------
| Company Module
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix'        => config('laravel-company-module.url.admin_url_prefix'),
    'middleware'    => config('laravel-company-module.url.middleware'),
    'namespace'     => config('laravel-company-module.controller.company_admin_namespace')
], function()
{
    if (config('laravel-company-module.routes.admin.company_edit')) {
        Route::get(config('laravel-company-module.url.company'), [
            'as' => 'admin.company.edit', 'uses' => config('laravel-company-module.controller.company') . '@edit'
        ]);
    }
    if (config('laravel-company-module.routes.admin.company_update')) {
        Route::post(config('laravel-company-module.url.company'), [
            'as' => 'admin.company.update', 'uses' => config('laravel-company-module.controller.company') . '@update'
        ]);
    }
    // api description photo remove
    if (config('laravel-company-module.routes.api.company_removePhoto')) {
        Route::post(config('laravel-company-module.url.company').'/remove-photo', [
            'as'                => 'api.company.removePhoto',
            'uses'              => config('laravel-company-module.controller.company').'@removePhoto'
        ]);
    }
});
