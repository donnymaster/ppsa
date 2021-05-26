<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;
use function Database\Seeders\ProductInformation\getIngredients;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (getIngredients() as $ingredient) {
            Ingredient::create([
                'unit_id' => rand(1, 20),
                'name' => $ingredient
            ]);
        }
    }
}
