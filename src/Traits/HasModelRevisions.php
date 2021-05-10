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
			$attributes = json_decode($revision->content, true);

			// Remove revision
			$revision->delete();
			$revision->save();

			// Overwrite Model's attributes
			return $this::update($attributes);
		}

		throw new \Exception('Unable to Revert to Revision');
	}
}