<?php

namespace Database\Factories;

use App\Models\CategoryRecipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryRecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryRecipe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => rand(1, 13),
        ];
    }
}
