<?php

namespace DaltonMcCleery\LaravelQuickStart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BannerPromo
 * @package DaltonMcCleery\LaravelQuickStart\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class BannerPromo extends Model
{
	use SoftDeletes;
	use HasFactory;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'banner_promos';

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
		'name', 'content', 'active', 'start_on', 'end_on'
	];

	protected $hidden = [
		'id', 'created_at', 'updated_at', 'deleted_at'
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'start_on' => 'datetime',
		'end_on' => 'datetime'
	];

	/**
	 * The "booted" method of the model.
	 *
	 * @return void
	 */
	protected static function booted()
	{
		$user = auth()->user();

		static::creating(function ($page) use ($user) {
			$page->author()->associate($user);
			$page->editor()->associate($user);
		});

		static::updating(function ($page) use ($user) {
			$page->editor()->associate($user);
		});
	}

	public function author() {
		return $this->belongsTo('App\Models\User');
	}

	public function editor() {
		return $this->belongsTo('App\Models\User');
	}

	protected static function newFactory()
	{
		return \DaltonMcCleery\LaravelQuickStart\Database\Factories\BannerPromoFactory::new();
	}
}