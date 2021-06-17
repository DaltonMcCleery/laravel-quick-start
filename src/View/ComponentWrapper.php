<?php

namespace App\View;

use Ahinkle\AutoResolvableComponents\AutoResolvableComponent;

class ComponentWrapper extends AutoResolvableComponent
{
	public $key;

	public $fold = false;

	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct($componentData, $loop = 0)
	{
		$this->key = $componentData->key;

		if ($loop < 1) {
			$this->fold = true;
		}

		if (method_exists($this, 'construct')) {
			$this->construct($componentData);
		}
	}
}
