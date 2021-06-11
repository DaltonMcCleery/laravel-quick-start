<?php

namespace DaltonMcCleery\LaravelQuickStart\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;

class Redirect extends \App\Nova\Resource
{
	/**
	 * The model the resource corresponds to.
	 *
	 * @var string
	 */
	public static $model = \DaltonMcCleery\LaravelQuickStart\Models\Redirect::class;

	/**
	 * The logical group associated with the resource.
	 *
	 * @var string
	 */
	public static $group = 'Content';

	/**
	 * The single value that should be used to represent the resource when being displayed.
	 *
	 * @var string
	 */
	public static $title = 'from_url';

	/**
	 * The columns that should be searched.
	 *
	 * @var array
	 */
	public static $search = [
		'from_url',
		'to_url',
	];

	/**
	 * Get the fields displayed by the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function fields(Request $request)
	{
		return [
			ID::make(__('ID'), 'id')->hideFromIndex(),

			Text::make('From', 'from_url')
				->creationRules('required', 'unique:redirects,from_url')
				->updateRules('required', 'unique:redirects,from_url,{{resourceId}}'),

			Text::make('To', 'to_url')
				->rules('required'),

			Select::make('Status', 'status_code')->options([
				'301' => '301 (Moved Permanently)',
				'302' => '302 (Found)',
				'303' => '303 (See Other)',
				'304' => '304 (Not Modified)',
				'307' => '307 (Temporary Redirect)',
				'308' => '308 (Permanent Redirect)',
			])->rules('required')->withMeta(['value' => $this->status_code ?: '301']),
		];
	}

	/**
	 * Get the cards available for the request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function cards(Request $request)
	{
		return [];
	}

	/**
	 * Get the filters available for the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function filters(Request $request)
	{
		return [];
	}

	/**
	 * Get the lenses available for the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function lenses(Request $request)
	{
		return [];
	}

	/**
	 * Get the actions available for the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function actions(Request $request)
	{
		return [];
	}
}
