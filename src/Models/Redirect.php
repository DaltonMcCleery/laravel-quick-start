<?php

namespace DaltonMcCleery\LaravelQuickStart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class Redirect
 * @package DaltonMcCleery\LaravelQuickStart\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Redirect extends Model
{
	use HasFactory;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'redirects';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'from_url',
		'to_url',
		'status_code',
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['created_at', 'updated_at'];

	/**
	 * Redirect to the provided URL.
	 *
	 * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
	public function redirect()
	{
		return redirect($this->to_url, $this->status_code);
	}
}