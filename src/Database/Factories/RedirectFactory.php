<?php

namespace DaltonMcCleery\LaravelQuickStart\Database\Factories;

use DaltonMcCleery\LaravelQuickStart\Models\Redirect;
use Illuminate\Database\Eloquent\Factories\Factory;

class RedirectFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Redirect::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
    public function definition()
    {
        return [
            'from_url'    => $this->faker->slug,
            'to_url'      => $this->faker->slug,
            'status_code' => 301,
        ];
    }
}
