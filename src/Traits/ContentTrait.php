<?php

namespace App\Traits;

use Manogi\Tiptap\Tiptap;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Infinety\Filemanager\FilemanagerField;
use Whitecube\NovaFlexibleContent\Flexible;
use ElevateDigital\CharcountedFields\TextCounted;
use OptimistDigital\MultiselectField\Multiselect;
use ElevateDigital\CharcountedFields\TextareaCounted;

/**
 * Trait ContentTrait
 * @package App\Traits
 */
trait ContentTrait
{
    /**
     * The content that belongs to the Flexible Components.
     *
     * @param bool $showHelp
     */
    protected function flexibleComponents($showHelp = true)
    {
        return Flexible::make('Content', 'content')
            ->help($showHelp ? 'Page Content can only be edited/added/deleted directly from the Page Resource' : '')
            ->button('Add Content')
            ->fullWidth()
            ->collapsed(true)

            // HTML
            ->addLayout('Textbox (WYSIWYG)', 'wysiwyg', [
                Select::make('Width', 'width')
                    ->options([
                        'slim' => 'Slim (70%)',
                        'full' => 'Full (100%)'
                    ])->displayUsingLabels()
                    ->stacked()->rules('required'),

                $this->wysiwyg()
            ])

            // Add More Layouts Here...
        ;
    }

    // ----------------------------------------------- HELPER METHODS ----------------------------------------------- //

    public function wysiwyg() {
        return
            Tiptap::make('Text', 'text')
                ->buttons([
                    'heading', 'italic', 'bold', 'code', 'link', 'strike', 'underline', 'superscript', 'subscript',
                    'bullet_list', 'ordered_list', 'code_block', 'blockquote', 'table', 'edit_html'
                ])
                ->headingLevels([2, 3, 4])
                ->stacked()->rules('required');
    }
}
