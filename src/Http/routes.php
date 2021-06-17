<?php

use Illuminate\Support\Facades\Route;
use DaltonMcCleery\LaravelQuickStart\Http\Middleware\CachePageResponse;
use DaltonMcCleery\LaravelQuickStart\Http\Controllers\QuickStartPageController;
use DaltonMcCleery\LaravelQuickStart\Http\Controllers\QuickStartSitemapController;

Route::middleware(['web'])->group(function () {
	// Sitemap
	Route::get('/sitemap.xml', [QuickStartSitemapController::class, 'index'])->name('sitemap');

	// Catch-all for routes with the exception of Nova routes.
	Route::get('/{slug?}', [QuickStartPageController::class, 'page'])
		->where('slug', '^(?!manage|nova|nova-api|nova-vendor).*')
		->middleware(CachePageResponse::class)
		->name('page');
});