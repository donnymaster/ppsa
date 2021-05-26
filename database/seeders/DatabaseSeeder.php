<?php

namespace Database\Seeders;

use App\Models\RecipeStep;
use App\Models\Doctor;
use App\Models\Recipe;
use App\Models\Blog;
use App\Models\CategoryRecipe;
use App\Models\DoctorMaterial;
use App\Models\Ration;
use App\Models\RationPart;
use App\Models\RationPartType;
use App\Models\RecipeCategory;
use App\Models\RecipeIngredient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    const COUNT_DOCTOR = 5;
    const COUNT_RECIPE = 5;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            UnitSeeder::class,
            IngredientSeeder::class,
            CategorySeeder::class,
        ]);

        $roleDoctor = Role::where('name', Role::DOCTOR)->firstOrFail();
        $roleUser = Role::where('name', Role::USER)->firstOrFail();

        User::factory()
            ->count(5)
            ->create([
                'role_id' => $roleUser->id,
            ]);

        $users = User::factory()
            ->count(5)
            ->create([
                'role_id' => $roleDoctor->id,
            ]);

        foreach ($users as $user) {
            $doctor = Doctor::factory()
                ->count(1)
                ->for($user)
                ->createOne();

            $ration = Ration::factory()
                ->count(1)
                ->for($user)
                ->createOne([
                    'is_doctor_create' => true,
                    'title' => 'Title ration ' . $doctor->id,
                ]);

            DoctorMaterial::factory()
                ->count(3)
                ->for($doctor)
                ->create();

            Blog::factory()
                ->count(5)
                ->for($doctor)
                ->create();

            $recipe = Recipe::factory()
                ->count(1)
                ->for($doctor)
                ->createOne([
                    'is_verified' => true,
                    'is_create_user' => false,
                ]);

            $this->createRationParts($ration->id, $recipe->id);

            CategoryRecipe::factory()
                ->count(3)
                ->for($recipe)
                ->create();

            RecipeIngredient::factory()
                ->count(5)
                ->for($recipe)
                ->create();

            RecipeStep::factory()
                ->count(10)
                ->for($recipe)
                ->create();
        }

        $this->call([
            ProductInfoSeeder::class,
        ]);
    }

    private function createRationParts($rationId, $recipeId)
    {
        $types = RationPartType::RATION_PART_TYPE;

        foreach ($types as $type) {
            $type = RationPartType::where('key', $type)->firstOrFail();

            RationPart::create([
                'ration_part_type_id' => $type->id,
                'recipe_id' => $recipeId,
                'ration_id' => $rationId,
            ]);
        }
    }
}
