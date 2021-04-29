<?php

namespace DaltonMcCleery\LaravelQuickStart\Http\Controllers;

use DaltonMcCleery\LaravelQuickStart\Models\Page;

class QuickStartSitemapController extends Controller
{
	/**
	 * Display a listing of the resource sitemap.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return response()->view('sitemap', [
			'pages' => Page::where('active', true)->get()
		])->header('Content-Type', 'text/xml');
	}
}