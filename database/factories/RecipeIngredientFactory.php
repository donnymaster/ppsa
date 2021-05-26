<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\RecipeIngredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeIngredientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RecipeIngredient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'count' => rand(1, 500),
            'ingredient_id' => rand(1, 842),
            'unit_id' => rand(1, 20),
        ];
    }
}
