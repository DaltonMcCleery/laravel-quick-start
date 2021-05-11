<?php

namespace DaltonMcCleery\LaravelQuickStart\Traits;

use DaltonMcCleery\LaravelQuickStart\Models\ModelRevision;

/**
 * Trait HasModelRevisions
 * @package DaltonMcCleery\LaravelQuickStart\Traits
 */
trait HasModelRevisions
{
	public $create_new_revision;

	public function revisions() {
		return $this->morphMany('DaltonMcCleery\LaravelQuickStart\Models\ModelRevision', 'revisionable_model');
	}

	public static function create_static_revision($model_data) {
		return (new self)->create_revision($model_data);
	}

	public function create_revision($model_data) {
		ModelRevision::create([
			'content' => $model_data->getOriginal(),
			'revisionable_model_type' => (new \ReflectionClass($model_data))->getName(),
			'revisionable_model_id' => $model_data->id
		]);

		$model_data->offsetUnset('create_new_revision');

		return $model_data;
	}

	public function revert_last_revision() {
		$last_revision = $this->revisions->last();

		if ($last_revision) {
			return $this->revert_to_revision($last_revision->id);
		}

		throw new \Exception('No Available Revisions');
	}

	public function revert_to_revision($revision_id) {
		$revision = $this->revisions()->where('id', $revision_id)->first();

		if ($revision) {
			$attributes = $revision->content;

			// Remove revision
			$revision->forceDelete();

			// Overwrite Model's attributes
			return $this::update($attributes);
		}

		throw new \Exception('Unable to Revert to Revision');
	}
}