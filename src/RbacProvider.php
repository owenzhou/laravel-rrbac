<?php

namespace Owenzhou\LaravelRbac;

use Illuminate\Support\ServiceProvider;

class RbacProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->loadViewsFrom(__DIR__.'/views', 'LaravelAsset');
		//$this->loadRoutesFrom(__DIR__.'/rbac.php');
		$this->loadMigrationsFrom(__DIR__.'/Migrations');
		$this->publishes([
			__DIR__.'/views' => base_path('resources/views'),
			__DIR__.'/Modles' => app_path(),
			__DIR__.'/Controllers' => app_path('Http/Controllers'),
			__DIR__.'/Middleware' => app_path('Http/Middleware'),
			__DIR__.'/Routes' => base_path('routes'),
		]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
