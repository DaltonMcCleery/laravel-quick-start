<?php

namespace DaltonMcCleery\LaravelQuickStart\Nova;

use Laravel\Nova\Panel;
use Manogi\Tiptap\Tiptap;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use ElevateDigital\CharcountedFields\TextCounted;

class BannerPromos extends \App\Nova\Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \DaltonMcCleery\LaravelQuickStart\Models\BannerPromo::class;

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
        'id', 'name'
    ];

    public static function label() {
        return 'Banner Promotions';
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
            ID::make()->sortable(),

            new Panel('Details and Scheduling', [
                TextCounted::make('Name')
                    ->sortable()->stacked()
                    ->maxChars(200)->warningAt(180)
                    ->help('Internal Use Only to identify the Banner Promo')
                    ->rules('required', 'max:200'),

                DateTime::make('Scheduled Start', 'start_on')
//                    ->format('MM/DD/YYYY')
                    ->sortable()->stacked()->nullable()
                    ->help('(OPTIONAL) DateTime for WHEN this Banner should be displayed, can be set in the future for scheduling'),

                DateTime::make('Scheduled End', 'end_on')
//                    ->format('MM/DD/YYYY')
                    ->sortable()->stacked()->nullable()
                    ->help('(OPTIONAL) DateTime for WHEN this Banner should stop being displayed, must be a datetime in PAST the Start date'),

                Boolean::make('Active')
                    ->trueValue(1)
                    ->falseValue(0)
                    ->sortable()->stacked()
                    ->withMeta([
                        'value' => $this->active ?? 'checked',
                    ])
                    ->help('Controls if the Banner is to be shown to public facing visitors')
                    ->rules('required')
            ]),

            new Panel('Banner', [
                Tiptap::make('Content')
                    ->buttons([
                        'heading',
                        'italic',
                        'bold',
                        'link',
                        'strike',
                        'underline',
                        'superscript',
                        'subscript',
                        'edit_html'
                    ])
                    ->headingLevels([2, 3, 4])
                    ->stacked()->rules('required'),
            ]),

            new Panel('Additional Information', [
                BelongsTo::make('Page Author', 'author', 'App\Nova\User')
                    ->hideWhenCreating(true)
                    ->hideFromIndex(true)->readonly(true)->stacked(),

                BelongsTo::make('Last Edited By', 'editor', 'App\Nova\User')
                    ->hideWhenCreating(true)->hideWhenUpdating(true)
                    ->hideFromIndex(true)->readonly(true)->stacked()
            ])
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
