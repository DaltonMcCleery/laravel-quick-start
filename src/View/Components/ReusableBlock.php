<?php

namespace App\View\Components;

use DaltonMcCleery\LaravelQuickStart\Traits\CacheTrait;
use Ahinkle\AutoResolvableComponents\AutoResolvableComponent;

class ReusableBlock extends AutoResolvableComponent
{
	use CacheTrait;

	public $content;

	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct($componentData)
	{
		$block_id = $componentData->attributes->block;
		$block = $this->getCache('reusable_block_'.$block_id, function() use ($block_id) {
			$dbBlock = \DaltonMcCleery\LaravelQuickStart\Models\ReusableBlock::where('active', 1)
				->where('id', $block_id)
				->first();

			// Set new cached Block info
			$this->setCache('reusable_block_'.$block_id, $dbBlock);

			return $dbBlock;
		});

		$this->content = $block->content;
	}
}
