<?php

namespace DaltonMcCleery\LaravelQuickStart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DaltonMcCleery\LaravelQuickStart\Traits\CacheTrait;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;

/**
 * Class Page
 * @package DaltonMcCleery\LaravelQuickStart\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Page extends Model
{
	use HasFlexible;
	use SoftDeletes;
	use CacheTrait;
	use HasFactory;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

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
		'name', 'title', 'slug', 'template', 'content', 'parent_id',
		// Metadata
		'meta_title', 'meta_description', 'meta_keywords',
		'og_title', 'og_description', 'social_image',
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
	 * The relationships that should always be loaded.
	 *
	 * @var array
	 */
	protected $with = ['parent'];

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

			// Clear cache
			static::clearCacheStatically('page_'.$page->slug);
		});
	}

	public function parent() {
		return $this->belongsTo('DaltonMcCleery\LaravelQuickStart\Models\Page', 'parent_id');
	}

	public function author() {
		return $this->belongsTo('App\Models\User', 'author_id');
	}

	public function editor() {
		return $this->belongsTo('App\Models\User', 'editor_id');
	}

	/**
	 * Return the relative URL to this resource
	 * @return string
	 */
	public function getSlugAttribute(): string
	{
		if ($this->slug) {
			$prefix = '';
			if ($this->parent) {
				$prefix = '/'.$this->parent->slug;
			}

			return $prefix.'/'.(($this->slug === 'home') ? '' : $this->slug);
		}

		return '/';
	}
}