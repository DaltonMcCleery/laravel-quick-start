<?php

namespace DaltonMcCleery\LaravelQuickStart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DaltonMcCleery\LaravelQuickStart\Traits\CacheTrait;

/**
 * Class NavigationMenu
 * @package DaltonMcCleery\LaravelQuickStart\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class NavigationMenu extends Model
{
	use SoftDeletes;
	use CacheTrait;
	use HasFactory;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'navigation_menu';

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
		'name', 'menu_order', 'link', 'type',
		'parent_id', 'page_id'
	];

	protected $hidden = [
		'id', 'created_at', 'updated_at', 'deleted_at'
	];

	/**
	 * The "booted" method of the model.
	 *
	 * @return void
	 */
	protected static function booted()
	{
		static::creating(function () {
			// Clear cache
			static::clearAllCacheStatically();
		});

		static::updating(function () {
			// Clear cache
			static::clearAllCacheStatically();
		});

		static::deleting(function () {
			// Clear cache
			static::clearAllCacheStatically();
		});
	}

	public function page() {
		return $this->belongsTo('DaltonMcCleery\LaravelQuickStart\Models\Page', 'page_id');
	}

	public function parent() {
		return $this->belongsTo('DaltonMcCleery\LaravelQuickStart\Models\NavigationMenu', 'parent_id');
	}

	public function children() {
		return $this->hasMany('DaltonMcCleery\LaravelQuickStart\Models\NavigationMenu', 'parent_id')
			->orderBy('menu_order');
	}

	protected static function newFactory()
	{
		return \DaltonMcCleery\LaravelQuickStart\Database\Factories\NavigationMenuFactory::new();
	}
}