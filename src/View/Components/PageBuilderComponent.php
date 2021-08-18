<?php

namespace App\View\Components;

use DaltonMcCleery\LaravelQuickStart\Traits\CacheTrait;
use Illuminate\View\Component;

class PageBuilderComponent extends Component
{
	use CacheTrait;

	public string $key;

	public string $layout;

	public array $vars = [];

	public bool $fold = false;

	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct($componentData, $loop = 0)
	{
		$this->key = $componentData->key;
		$this->layout = $componentData->layout;

		if ($loop < 3) {
			$this->fold = true;
		}

		if (method_exists($this, 'construct')) {
			$this->construct($componentData);
		} else {
			$this->resolveAttributableProperties($componentData);
		}
	}

	/**
	 * Resolve and assign the component attributable properties.
	 *
	 * @param object $content
	 */
	protected function resolveAttributableProperties(object $content)
	{
		collect($content->attributes)
			->each(function ($attribute, $key) {
				$this->vars[$key] = $this->vars[$key] ?? $attribute;
			});

		// Check if have any nullable attribute properties, set as empty string:
		collect(get_object_vars($this))
			->reject(fn ($value, $property) => ($property === 'attributes' || $property === 'componentName' || $property === 'except')) // Native Laravel Component Properties.
			->filter(fn ($value, $property) => is_null($value))
			->each(fn ($attribute, $key) => $this->vars[$key] = '');

		if ($this->layout === 'reusable-block') {
			$block_id = $this->vars['block'];
			$block = $this->getCache('reusable_block_'.$block_id, function () use ($block_id) {
				$dbBlock = \DaltonMcCleery\LaravelQuickStart\Models\ReusableBlock::where('active', 1)
					->where('id', $block_id)
					->first();

				// Set new cached Block info
				$this->setCache('reusable_block_'.$block_id, $dbBlock);

				return $dbBlock;
			});

			$this->vars['content'] = $block->content ?? [];
		}
	}

	public function render()
	{
		return view("components.{$this->layout}", $this->vars);
	}
}