<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    const PATH_FILE = 'default/article.png';

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Title recipe 1',
            'time_preparing' => rand(10, 100),
            'count_feed' => rand(1, 10),
            'is_verified' => false,
            'background' => self::PATH_FILE,
            'is_create_user' => 1,
        ];
    }
}
