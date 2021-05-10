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
		$active = ['active' => true];
		if (Auth::check()) {
			if (in_array(Auth::user()->email, config('quick_start.view_unpublished_pages'))) {
				$active = [];
				$request->session()->flash('unpublished', 'Page is unpublished');
			}
		}

		// Get the requested Page, if any. (check cache first, else check DB)
		$segments = $this->get_segments($request);
		$page = $this->getCache('page_'.$segments->last(), function() use ($segments, $active) {
			// Empty cache, get Page and re-add them to the cache
			$dbPage = Page::with(['parent' => function ($query) use ($segments, $active) {
				if ($segments->count() > 1) {
					// more than 1 segment found, find Parent Page
					$query->where(array_merge($active, [
						'slug' => $segments->first()
					]));
				}
			}])
				->where(array_merge($active, [
					'slug' => $segments->last()
				]))
				// If the Page HAS a parent page associated with it, the bare slug should not allow the page to be rendered
				->where('parent_id', ($segments->count() > 1 ? '!=' : '='), null)
				->firstOrFail();

			// Set new cached page info
			$this->setCache('page_'.$segments->last(), $dbPage);

			return $dbPage;
		});

		return view(
			'templates.'.($page->template ?: 'page'),
			['page' => $page]
		);
	}

	/**
	 * The requested slug segments from the URL Request.
	 *
	 * @param Request $request
	 * @return \Illuminate\Support\Collection
	 */
	protected function get_segments(Request $request)
	{
		return collect($request->segments() ?: ['home']);
	}
}