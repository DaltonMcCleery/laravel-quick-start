<?php

namespace DaltonMcCleery\LaravelQuickStart\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use DaltonMcCleery\LaravelQuickStart\Models\NavigationMenu;

class NavigationMenuFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = NavigationMenu::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'name' => $this->faker->uuid,
			'menu_order' => '1',
			'link' => $this->faker->url,
			'type' => 'DESKTOP',
			'parent_id' => null,
			'page_id' => null
		];
	}
}
