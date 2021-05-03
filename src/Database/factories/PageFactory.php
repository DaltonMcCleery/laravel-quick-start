<?php

namespace DaltonMcCleery\LaravelQuickStart\Database\factories;

use DaltonMcCleery\LaravelQuickStart\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->uuid,
            'title' => $this->faker->uuid,
            'slug' => $this->faker->slug,
            'template' => 'page',
            'active' => true,
            'meta_title' => $this->faker->realText(50),
            'og_title' => $this->faker->realText(50),
            'meta_description' => $this->faker->realText(200),
            'og_description' => $this->faker->realText(200),
            'meta_keywords' => 'test, metadata, factory',
            'social_image' => $this->faker->imageUrl()
        ];
    }
}
