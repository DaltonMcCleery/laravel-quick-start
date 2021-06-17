<?php

namespace App\View\Components;

use App\View\ComponentWrapper;

class Wysiwyg extends ComponentWrapper
{
    public $html;
    public $width;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function construct($componentData)
    {
        $this->html = $componentData->attributes->text ?: null;
        $this->width = $componentData->attributes->width ?: 'full';
    }
}
