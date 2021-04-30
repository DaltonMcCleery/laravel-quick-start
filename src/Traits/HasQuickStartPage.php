<?php

namespace DaltonMcCleery\LaravelQuickStart\Traits;

/**
 * Trait HasQuickStartPage
 * @package DaltonMcCleery\LaravelQuickStart\Traits
 */
trait HasQuickStartPage
{
	public function page() {
		return $this->belongsTo('DaltonMcCleery\LaravelQuickStart\Models\Page', 'page_id');
	}

	public function getPageNameAttribute()
	{
		return $this->page->name;
	}

	public function getPageTitleAttribute()
	{
		return $this->page->title;
	}

	public function getPageContentAttribute()
	{
		return $this->page->content;
	}

	public function getPageTemplateAttribute()
	{
		return $this->page->template;
	}

	public function getPageMetaTitleAttribute()
	{
		return $this->page->meta_title;
	}

	public function getPageMetaDescriptionAttribute()
	{
		return $this->page->meta_description;
	}

	public function getPageMetaKeywordsAttribute()
	{
		return $this->page->meta_keywords;
	}

	public function getPageOgTitleAttribute()
	{
		return $this->page->og_title;
	}

	public function getPageOgDescriptionAttribute()
	{
		return $this->page->og_description;
	}

	public function getPageSocialImageAttribute()
	{
		return $this->page->social_image;
	}
}