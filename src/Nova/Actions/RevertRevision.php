<?php

namespace DaltonMcCleery\LaravelQuickStart\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\Heading;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\InteractsWithQueue;
use DaltonMcCleery\LaravelQuickStart\Models\ModelRevision;

class RevertRevision extends Action
{
	use InteractsWithQueue, Queueable;

	/**
	 * Indicates if this action is only available on the resource detail view.
	 *
	 * @var bool
	 */
	public $onlyOnDetail = true;

	protected $model;
	protected $request;

	public function __construct($request = null, $model = null)
	{
		$this->request = $request;
		$this->model = $model;
	}

	/**
	 * Perform the action on the given models.
	 *
	 * @param  \Laravel\Nova\Fields\ActionFields  $fields
	 * @param  \Illuminate\Support\Collection  $models
	 * @return mixed
	 */
	public function handle(ActionFields $fields, Collection $models)
	{
		foreach ($models as $model) {
			if ($fields->revision_id) {
				try {
					$model->revert_to_revision($fields->revision_id);
				} catch (\Exception $exception) {
					return Action::danger($exception->getMessage());
				}
			} else {
				return Action::danger('No Revisions available');
			}
		}

		return Action::message('Reverted to Revision');
	}

	/**
	 * Get the fields available on the action.
	 *
	 * @return array
	 */
	public function fields()
	{
		if ($this->request && $this->model) {
			$revisions = ModelRevision::where('revisionable_model_id', $this->request->resourceId)
				->where('revisionable_model_type', (new \ReflectionClass($this->model->resource))->getName())
				->get()
				->mapWithKeys(function ($revision) {
					return [$revision->id => ['label' => $revision->created_at->format('g:ia \o\n l jS, F Y')]];
				})
				->toArray();

			if (! empty($revisions)) {
				return [
					Select::make('Revision', 'revision_id')
						->options($revisions)
						->displayUsingLabels()
						->stacked()
						->help('Select a Revision by timestamp to revert back to')
						->rules('required')
				];
			}
		}

		return [
			Heading::make('No Revisions are available.')
		];
	}
}
