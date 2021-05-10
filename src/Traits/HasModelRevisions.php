<?php

namespace DaltonMcCleery\LaravelQuickStart\Traits;

/**
 * Trait HasModelRevisions
 * @package DaltonMcCleery\LaravelQuickStart\Traits
 */
trait HasModelRevisions
{
	public function revisions() {
		return $this->morphMany('DaltonMcCleery\LaravelQuickStart\Models\ModelRevision', 'revisionable_model');
	}

	public function last_revision() {
		return $this->revisions()->latest();
	}
}