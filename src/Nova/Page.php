<?php

namespace DaltonMcCleery\LaravelQuickStart\Nova;

use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;
use App\Traits\ContentTrait;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\BelongsTo;
use Infinety\Filemanager\FilemanagerField;
use DaltonMcCleery\LaravelQuickStart\Nova\Actions\RevertRevision;

class Page extends \App\Nova\Resource
{
	use ContentTrait;

	/**
	 * The model the resource corresponds to.
	 *
	 * @var string
	 */
	public static $model = \DaltonMcCleery\LaravelQuickStart\Models\Page::class;

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
		'title',
		'name'
	];

	public function subtitle() {
		return "Page Template: ".$this->renderTemplate($this->template);
	}

	public function renderTemplate($template) {
		$template = ucwords(str_replace('_', ' ', $template));
		$exploded = explode('.', $template);
		if (count($exploded) > 1) {
			return ucwords($exploded[1]);
		}

		return $template;
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
			MorphTo::make('Extendable Page', 'extendable_page')->types(config('quick_start.page_relationships'))
				->hideWhenCreating()->hideWhenUpdating()->hideFromIndex(),

			ID::make()->sortable()->hideFromIndex(),

			(new Panel('Page Details', $this->basicInformationFields()))->withToolbar(),

			new Panel('SEO / Meta Properties', $this->metadataFields()),

			new Panel('Page Content', [
				Select::make('Template', 'template')
					->sortable()->stacked()->required()
					->options(
						array_merge(['page' => 'Basic Page'], config('quick_start.page_templates'))
					)
					->displayUsingLabels(),

				$this->flexibleComponents(true),

				Boolean::make('Create New Revision', 'create_new_revision')
					->trueValue(1)
					->falseValue(0)
					->sortable()->stacked()
					->hideFromDetail()->hideFromIndex()->hideWhenCreating()
					->help('Create a new Page revision upon saving that can be reverted to at any time.')
					->rules('nullable')
			]),
		];
	}

	/**
	 * The Basic Information fields for the resource.
	 *
	 * @return array
	 */
	protected function basicInformationFields()
	{
		return [
			Text::make('Page Name', 'name')
				->sortable()->stacked()
				->rules('required', 'max:255')
				->help('Defines the Page\'s name for Internal Use Only (this will not show up to the public)'),

			Text::make('Title')
				->sortable()->stacked()
				->withMeta([
					'extraAttributes' => [
						'placeholder' => 'Page Title',
					],
				])
				->rules('required', 'max:255'),

			Text::make('Page URL', 'slug')
				->sortable()->stacked()
				->rules('required', 'max:255')
				->creationRules('unique:pages,slug')
				->updateRules('unique:pages,slug,{{resourceId}}')
				->help('
				    <ul>
                        <li>Do not include the starting "/" slash</li>
                        <li>Do not include special characters (!@#$%^&*()_+)</li>
                        <li>Use a "-" dash to indicate a space</li>
                        <li>Use all lowercase letters</li>
                    </ul>
				')
				->displayUsing(function() {
					if ($this->slug) {
						return '<a href="'.$this->page_slug.'" target="_blank">'.$this->slug.'</a>';
					}

					return '<strong style="color: #f44336">Please Enter a URL</strong>';
				})->asHtml(),

			BelongsTo::make('Parent Page', 'parent', 'DaltonMcCleery\LaravelQuickStart\Nova\Page')
				->stacked()->hideFromIndex()->hideWhenUpdating()->hideWhenCreating(),

			Select::make('Parent Page', 'parent_id')
				->stacked()->nullable()->hideFromDetail()->hideFromIndex()
				->options($this->getParentPageOptions())
				->help('A page that is the parent of this one, this means that the Parent Page\'a URL is tied to this page. <br/>
                            Example: creating a page with "/test" as the Page URL and setting a Parent Page of "/first" means this page
                            now becomes "/first/test" when navigating to it in the browser'),

			BelongsTo::make('Page Author', 'author', 'App\Nova\User')
				->hideWhenCreating(true)->hideWhenUpdating(true)->nullable()
				->hideFromIndex(true)->readonly(true)->stacked(),

			BelongsTo::make('Last Edited By', 'editor', 'App\Nova\User')
				->hideWhenCreating(true)->nullable()
				->hideFromIndex(true)->readonly(true)->stacked(),

			Boolean::make('Active')
				->trueValue(1)
				->falseValue(0)
				->sortable()->stacked()
				->withMeta(['value' => $this->active ?? 'checked'])
				->help('Controls if the page is visible to public facing visitors.')
				->rules('required')
		];
	}

	protected function getParentPageOptions() {
		return \DaltonMcCleery\LaravelQuickStart\Models\Page::all()
			->mapWithKeys(function ($page) {
				return [$page->id => ['label' => $page->name.' (Template: "'.$this->renderTemplate($page->template).'")']];
			})->toArray();
	}

	protected function metadataFields() {
		return [
			Text::make('Meta Title')
				->hideFromIndex()->stacked()
				->help('Populates the title of the webpage for search engines.')
				->rules('required', 'max:255'),

			Textarea::make('Meta Description')
				->hideFromIndex()->stacked()
				->help('Meta description must be no longer than 200 characters.')
				->rules('required', 'max:200'),

			Text::make('Open Graph Title', 'og_title')
				->hideFromIndex()->stacked()
				->help('The title that populates when the page is shared via Twitter and Facebook. Uses page title if left blank. Maximum 95 Characters.')
				->rules('nullable', 'max:95'),

			Textarea::make('Open Graph Description', 'og_description')
				->hideFromIndex()->stacked()
				->help('The description that populates when this page is shared via Twitter and Facebook. Uses Meta Description if left blank. Maximum 300 Characters.')
				->rules('nullable', 'max:300'),

			Textarea::make('Meta Keywords')
				->hideFromIndex()->stacked()
				->help('Populates specific keywords for search engines. Please comma separate each keyword')
				->rules('nullable', 'max:255'),

			FilemanagerField::make('Social Image', 'social_image')
				->help('The image that appears in share dialogues when a visitor shares this page via Twitter and Facebook. Optimal image size and format is 1600x1600px PNG files. It is not recommended to use text within the image as some cropping may occur. Will use logo image if left blank.')
				->filterBy('images')
				->validateUpload('image', 'max:2000')
				->displayAsImage()->stacked()
				->rules('nullable'),
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
		return [
			new RevertRevision($request->resourceId, $this)
		];
	}
}