<?php

namespace DaltonMcCleery\LaravelQuickStart\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelRevision
 * @package DaltonMcCleery\LaravelQuickStart\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ModelRevision extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'model_revisions';

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['created_at', 'updated_at'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'content', 'revisionable_model_type', 'revisionable_model_id'
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'content' => 'object',
	];

	public function revisionable_model() {
		return $this->morphTo();
	}
}