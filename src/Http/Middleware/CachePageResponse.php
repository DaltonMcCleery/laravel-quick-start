<?php

namespace DaltonMcCleery\LaravelQuickStart\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DaltonMcCleery\LaravelQuickStart\Traits\CacheTrait;

class CachePageResponse
{
	use CacheTrait;

	public function handle(Request $request, Closure $next)
	{
		$response = $next($request);

		if (
			$response->headers->has('custom-cached-page')
			&& (env('APP_ENV') === 'prod' || env('APP_ENV') === 'production')
		) {
			// 168hrs = 1 week
			$this->setCache($response->headers->get('custom-cached-page'), $response->getContent(), 168);
		}

		return $response;
	}
}