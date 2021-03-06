<?php

namespace App\Traits;

use Manogi\Tiptap\Tiptap;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Infinety\Filemanager\FilemanagerField;
use Whitecube\NovaFlexibleContent\Flexible;
use OptimistDigital\MultiselectField\Multiselect;

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
	 * @param bool $showReusable
	 */
    protected function flexibleComponents($showHelp = true, $showReusable = true)
    {
        $content = Flexible::make('Content', 'content')
            ->help($showHelp ? 'Page Content can only be edited/added/deleted directly from the Page Resource' : '')
            ->button('Add Content')
            ->fullWidth()
            ->collapsed(true)

            // HTML
            ->addLayout('Textbox (WYSIWYG)', 'wysiwyg', $this->wysiwyg(true))

            // Add More Layouts Here...
        ;

        if ($showReusable) {
	        // Reusable Blocks
	        $content->addLayout('Reusable Block', 'reusable-block', $this->reusable_block());
        }

        return $content;
    }

    // ----------------------------------------------- LAYOUT METHODS ----------------------------------------------- //

    public function wysiwyg($showWidth = false) {
    	if ($showWidth) {
		    return [
			    Select::make('Width', 'width')
				    ->options([
					    'slim' => 'Slim (70%)',
					    'full' => 'Full (100%)'
				    ])->displayUsingLabels()
				    ->stacked()->rules('required'),

			    Tiptap::make('Text', 'text')
				    ->buttons([
					    'heading', 'italic', 'bold', 'code', 'link', 'strike', 'underline', 'superscript', 'subscript',
					    'bullet_list', 'ordered_list', 'code_block', 'blockquote', 'table', 'edit_html'
				    ])
				    ->headingLevels([2, 3, 4])
				    ->stacked()->rules('required')
		    ];
	    }

    	return
		    Tiptap::make('Text', 'text')
			    ->buttons([
				    'heading', 'italic', 'bold', 'code', 'link', 'strike', 'underline', 'superscript', 'subscript',
				    'bullet_list', 'ordered_list', 'code_block', 'blockquote', 'table', 'edit_html'
			    ])
			    ->headingLevels([2, 3, 4])
			    ->stacked()->rules('required');
    }

    public function reusable_block() {
    	return [
		    Select::make('Block', 'block')
			    ->sortable()->stacked()->required()
			    ->options(
				    \DaltonMcCleery\LaravelQuickStart\Models\ReusableBlock::where('active', 1)->get()
					    ->mapWithKeys(function ($block) {
						    return [$block->id => ['label' => $block->name]];
					    })->toArray()
			    )
			    ->displayUsingLabels(),
	    ];
    }
}
