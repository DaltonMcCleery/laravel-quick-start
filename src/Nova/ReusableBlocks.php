<?php

namespace DaltonMcCleery\LaravelQuickStart\Nova;

use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;
use App\Traits\ContentTrait;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Infinety\Filemanager\FilemanagerField;
use ElevateDigital\CharcountedFields\TextCounted;
use ElevateDigital\CharcountedFields\TextareaCounted;

class ReusableBlocks extends \App\Nova\Resource
{
	use ContentTrait;

	/**
	 * The model the resource corresponds to.
	 *
	 * @var string
	 */
	public static $model = \DaltonMcCleery\LaravelQuickStart\Models\ReusableBlock::class;

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
	public static $title = 'name';

	/**
	 * The columns that should be searched.
	 *
	 * @var array
	 */
	public static $search = [
		'id',
		'name'
	];

	public function subtitle() {
		return "Layout: ".$this->layout;
	}

	/**
	 * Get the fields displayed by the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function fields(Request $request)
	{
		return [
			ID::make()->sortable()->hideFromIndex(),

			TextCounted::make('Reusable Block Name', 'name')
				->sortable()->stacked()
				->maxChars(255)->warningAt(230)
				->rules('required', 'max:255')
				->help('Defines the Block\'s name for Internal Use Only (this will not show up to the public)'),

			Boolean::make('Active')
				->trueValue(1)
				->falseValue(0)
				->sortable()->stacked()
				->withMeta(['value' => $this->active ?? 'checked'])
				->help('Controls if the Block is visible to public facing visitors.')
				->rules('required'),

			new Panel('Block Content', [
				$this->flexibleComponents(false, false)
			]),
		];
	}

	// -------------------------------------------------------------------------------------------------------------- //

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