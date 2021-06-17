<?php

namespace DaltonMcCleery\LaravelQuickStart\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DaltonMcCleery\LaravelQuickStart\Models\Page;
use DaltonMcCleery\LaravelQuickStart\Traits\CacheTrait;

class QuickStartPageController extends Controller
{
	use CacheTrait;

	/**
	 * Resolves the view based on the URI provided.
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function page(Request $request)
	{
		$active = true;
		if (Auth::check()) {
			if (in_array(Auth::user()->email, config('quick_start.view_unpublished_pages'))) {
				$active = false;
				$request->session()->flash('unpublished', 'Page is unpublished');
			}
		}

		// Get the requested Page, if any. (check cache first, else check DB)
		$url = $this->getUrl($request);
		$key = "page_{$url}";

		$page = $this->getCache($key, function() use ($key, $url, $active) {
			// Empty cache, get Page and re-add them to the cache
			if ($active) {
				$pages = Page::where('active', true)->get();
			} else {
				$pages = Page::all();
			}

			$dbPage = $pages->where('page_slug', '=', $url)->first();

			if (! $dbPage) {
				abort(404);
			}

			// Set new cached page info
			$this->setCache($key, $dbPage);

			return $dbPage;
		});

		if (! $page instanceof Page) {
			// HTML cache
			return response($page, 200);
		}

		return response(view(
			'templates.'.($page->template ?: 'page'),
			['page' => $page]
		), 200, ['custom-cached-page' => $key]);
	}

	/**
	 * The requested slug segments from the URL Request.
	 *
	 * @param Request $request
	 * @return string
	 */
	protected function getUrl(Request $request)
	{
		return '/'.collect($request->segments())->join('/');
	}
}
