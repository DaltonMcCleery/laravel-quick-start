<?php

namespace DaltonMcCleery\LaravelQuickStart;

use Illuminate\Support\Facades\Facade;

/**
 * Class LaravelQuickStartStorageFacade
 * @package DaltonMcCleery\LaravelQuickStart
 */
class LaravelQuickStartStorageFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelQuickStart';
    }
}
