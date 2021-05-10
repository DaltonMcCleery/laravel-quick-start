<?php

namespace DaltonMcCleery\LaravelQuickStart\Traits;

use DaltonMcCleery\LaravelQuickStart\Models\ModelRevision;

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

	public static function create_static_revision($model_data) {
		(new self)->create_revision($model_data);
	}

	public function create_revision($model_data) {
		ModelRevision::create([
			'content' => json_encode($model_data->getOriginal()),
			'revisionable_model_type' => (new \ReflectionClass($model_data))->getName(),
			'revisionable_model_id' => $model_data->id
		]);
	}
}