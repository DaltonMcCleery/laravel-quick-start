<?php

namespace DaltonMcCleery\LaravelQuickStart\View\Components;

use Ahinkle\AutoResolvableComponents\AutoResolvableComponent;

class Wysiwyg extends AutoResolvableComponent
{
    public $html;
    public $width;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($componentData)
    {
        $this->html = $componentData->attributes->text ?: null;
        $this->width = $componentData->attributes->width ?: 'full';
    }
}
