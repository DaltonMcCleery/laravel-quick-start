<?php

namespace DaltonMcCleery\LaravelQuickStart\Database\Factories1;

use Illuminate\Database\Eloquent\Factories\Factory;
use DaltonMcCleery\LaravelQuickStart\Models\BannerPromo;

class BannerPromoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BannerPromo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'content' => '<p>'.$this->faker->sentence.'</p>',
            'active' => true
        ];
    }
}
