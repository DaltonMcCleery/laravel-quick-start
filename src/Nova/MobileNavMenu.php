<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use App\Nova\Filters\MenuType;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use ElevateDigital\CharcountedFields\TextCounted;

class MobileNavMenu extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \DaltonMcCleery\LaravelQuickStart\Models\NavigationMenu::class;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Menus';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name'
    ];

    public static function label() {
        return 'Mobile Nav';
    }

    public function title() {
        if ($this->type === 'MOBILE') {
            return $this->name;
        }

        return 'invalid type - cant pick';
    }

    public static $orderBy = ['menu_order' => 'asc'];

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

            TextCounted::make('Menu Name', 'name')
                ->stacked()
                ->maxChars(255)->warningAt(230)
                ->help('Populates the name of the Option.')
                ->rules('required', 'max:255'),

            Number::make('Menu Order', 'menu_order')
                ->stacked()->sortable()
                ->min(1)->max(1000)->step(1)
                ->help('The order in which this menu item is displayed within the navigation. Lower numbers means it shows up first while higher numbers means it shows up later')
                ->rules('required'),

            TextCounted::make('Menu Link (optional)', 'link')
                ->stacked()
                ->maxChars(255)->warningAt(230)
                ->help('The URL this menu will direct the user to when clicked. RECOMMEND USING PAGE OPTION BELOW')
                ->rules('nullable', 'max:255'),

            BelongsTo::make('Linked Page', 'page', 'App\Nova\Page')
                ->stacked()->nullable()
                ->help('The Page this menu item will link to'),

            BelongsTo::make('Parent Menu Link', 'parent', 'DaltonMcCleery\LaravelQuickStart\Nova\MobileNavMenu')
                ->stacked()->nullable(),

            HasMany::make('Children Links', 'children', 'DaltonMcCleery\LaravelQuickStart\Nova\MobileNavMenu')
                ->stacked()->nullable(),

            TextCounted::make('Type')
                ->help('DO NOT CHANGE')
                ->hideFromIndex(true)->hideFromDetail(true)
                ->stacked()->withMeta([
                    'value' => 'MOBILE',
                    'type' => 'hidden'
                ]),
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
        return [
            new MenuType('MOBILE')
        ];
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
