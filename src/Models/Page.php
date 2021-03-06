<?php

namespace DaltonMcCleery\LaravelQuickStart\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\QuickStartPageExtensions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DaltonMcCleery\LaravelQuickStart\Traits\CacheTrait;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;
use DaltonMcCleery\LaravelQuickStart\Traits\HasModelRevisions;

/**
 * Class Page
 * @package DaltonMcCleery\LaravelQuickStart\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Page extends Model
{
	use CacheTrait;
	use HasFactory;
	use HasFlexible;
	use SoftDeletes;
	use HasModelRevisions;
	use QuickStartPageExtensions;

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
	protected $with = [
		'parent'
	];

	protected $appends = [
		'page_slug'
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
			if ($page->create_new_revision) {
				$page = self::create_static_revision($page);
			}

			$page->editor()->associate($user);

			// Clear cache
			static::clearCacheStatically('page_'.$page->page_slug);
		});

		static::deleting(function ($page) {
			// Clear cache
			static::clearCacheStatically('page_'.$page->page_slug);
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

	public function extendable_page() {
		return $this->morphTo();
	}

	/**
	 * Return the relative URL to this resource
	 * @return string
	 */
	public function getPageSlugAttribute(): string
	{
		if ($this->slug) {
			$prefix = $this->buildParentSlug('', $this);

			return $prefix.'/'.(($this->slug === 'home') ? '' : $this->slug);
		}

		return '#';
	}

	private function buildParentSlug($slug, $model) {
		if ($model->parent) {
			$slug = "/{$model->parent->slug}{$slug}";

			return $this->buildParentSlug($slug, $model->parent);
		}

		return $slug;
	}

	protected static function newFactory()
	{
		return \DaltonMcCleery\LaravelQuickStart\Database\Factories\PageFactory::new();
	}
}
