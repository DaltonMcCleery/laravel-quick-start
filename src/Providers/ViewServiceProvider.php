<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Pass the nav variable from the composer to views with this name
		View::creator(
			config('quick_start.view_composer_pages'),
			'DaltonMcCleery\LaravelQuickStart\View\Composers\NavigationMenuComposer'
		);
	}
}