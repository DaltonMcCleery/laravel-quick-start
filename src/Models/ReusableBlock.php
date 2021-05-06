<?php

namespace DaltonMcCleery\LaravelQuickStart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DaltonMcCleery\LaravelQuickStart\Traits\CacheTrait;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;

/**
 * Class ReusableBlock
 * @package DaltonMcCleery\LaravelQuickStart\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ReusableBlock extends Model
{
	use HasFlexible;
	use SoftDeletes;
	use CacheTrait;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'reusable_blocks';

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'active'
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'content' => 'object',
	];

	/**
	 * The "booted" method of the model.
	 *
	 * @return void
	 */
	protected static function booted()
	{
		static::creating(function ($block) {
			// Clear cache
			static::clearCacheStatically('reusable_block_'.$block->id);
		});

		static::updating(function ($block) {
			// Clear cache
			static::clearCacheStatically('reusable_block_'.$block->id);
		});
	}
}