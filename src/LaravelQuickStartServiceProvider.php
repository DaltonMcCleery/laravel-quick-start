<?php

namespace DaltonMcCleery\LaravelQuickStart;

use DaltonMcCleery\LaravelQuickStart\Console\Commands\MigrateToBackbone;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelQuickStartServiceProvider
 * @package DaltonMcCleery\LaravelQuickStart
 */
class LaravelQuickStartServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 */
	public function boot()
	{
		if (config('quick_start.autoload_routes', true)) {
			$this->autoRegisterRoutes();
		}

		$this->registerMigrations();
		$this->registerPublishing();

		if ($this->app->runningInConsole()) {
			$this->commands([
				MigrateToBackbone::class,
			]);
		}
	}

	/**
	 * Register the package routes.
	 *
	 * @return void
	 */
	public static function registerRoutes()
	{
		Route::middleware('web')
			->namespace('DaltonMcCleery\LaravelQuickStart\Http\Controllers')
			->group(__DIR__ . '/Http/routes.php');
	}

	/**
	 * Register the package routes.
	 *
	 * @return void
	 */
	private function autoRegisterRoutes()
	{
		Route::group($this->routeConfiguration(), function () {
			$this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
		});
	}

	/**
	 * Get the Telescope route group configuration array.
	 *
	 * @return array
	 */
	private function routeConfiguration()
	{
		return [
			'namespace' => 'DaltonMcCleery\LaravelQuickStart\Http\Controllers',
		];
	}

    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function registerMigrations()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

	    $this->publishes([
		    __DIR__ . '/Database/Migrations' => database_path('migrations'),
	    ], 'migrations');

	    $this->publishes([
		    __DIR__.'/config/quick_start.php' => config_path('quick_start.php'),
	    ], 'config');

	    $this->publishes([
		    __DIR__.'/resources' => resource_path('views'),
	    ], 'resources');

	    $this->publishes([
		    __DIR__.'/View/Components' => app_path('View/Components'),
	    ], 'views');

	    $this->publishes([
		    __DIR__.'/Traits/ContentTrait.php' => app_path('Traits/ContentTrait.php'),
		    __DIR__.'/Traits/ValidationTrait.php' => app_path('Traits/ValidationTrait.php'),
		    __DIR__.'/Traits/QuickStartPageExtensions.php' => app_path('Traits/QuickStartPageExtensions.php'),
	    ], 'traits');

	    $this->publishes([
		    __DIR__.'/Providers/ViewServiceProvider.php' => app_path('Providers/ViewServiceProvider.php')
	    ], 'provider');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
