<?php

namespace DaltonMcCleery\LaravelQuickStart\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DaltonMcCleery\LaravelQuickStart\Models\Redirect;

class RedirectRequests
{
	public function handle(Request $request, Closure $next)
	{
		return optional(Redirect::whereFromUrl($request->path())->first())
				->redirect() ?? $next($request);
	}
}