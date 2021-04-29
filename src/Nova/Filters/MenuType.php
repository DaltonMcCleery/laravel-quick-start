<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class MenuType extends BooleanFilter
{
    /**
     * The column that should be filtered on.
     *
     * @var string
     */
    protected $defaultType;

    /**
     * Create a new filter instance.
     *
     * @param  string  $defaultType
     * @return void
     */
    public function __construct($defaultType)
    {
        $this->defaultType = $defaultType;
    }

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('type', '=', $this->defaultType);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Main Nav Menu' => 'MAIN',
            'Mobile Nav Menu' => 'MOBILE',
	        'Footer Nav Menu' => 'FOOTER'
        ];
    }

    /**
     * The default value of the filter.
     *
     * @var string
     */
    public function default()
    {
        return $this->defaultType;
    }
}
