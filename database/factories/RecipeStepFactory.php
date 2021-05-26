<?php

namespace Database\Factories;

use App\Models\RecipeStep;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;

class RecipeStepFactory extends Factory
{
    const MAX_NB_CHARS = 2000;
    const DEFAULT_PATH_IMG = 'default/article.png';

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RecipeStep::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker\Factory::create('uk_UA');

        return [
            'title' => 'Title recipe step 1',
            'description' => $faker->text(self::MAX_NB_CHARS),
            'img_path' => self::DEFAULT_PATH_IMG,
        ];
    }
}
