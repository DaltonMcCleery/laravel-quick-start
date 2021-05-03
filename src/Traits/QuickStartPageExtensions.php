<?php

namespace App\Traits;

/**
 * Trait QuickStartPageExtensions
 * @package App\Traits
 */
trait QuickStartPageExtensions
{
	/**
	 * The relationships that should always be loaded.
	 *
	 * @var array
	 */
	protected $with = [
		'parent',
		// add any more eager-loaded relationships
	];

	/*
	public function product() {
		return $this->hasOne('App\Models\Product', 'page_id');
	}
	*/
}