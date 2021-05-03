<?php

namespace DaltonMcCleery\LaravelQuickStart;

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
		$this->registerRoutes();
		$this->registerMigrations();
		$this->registerPublishing();
	}

	/**
	 * Register the package routes.
	 *
	 * @return void
	 */
	private function registerRoutes()
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
		    __DIR__ . '/Database/factories'  => database_path('factories'),
	    ], 'migrations');

	    $this->publishes([
		    __DIR__.'/config/quick_start.php' => config_path('quick_start.php'),
	    ], 'config');

	    $this->publishes([
		    __DIR__.'/resources' => resource_path('views'),
	    ], 'resources');

	    $this->publishes([
		    __DIR__.'/View/Components' => app_path('View/Components')
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
