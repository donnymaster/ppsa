<?php

namespace App\Services;

use App\Contracts\FileStorageServiceContract as FileStorage;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\RecipeStep;

class RecipeService
{
    const DEFAULT_IMG_INCLUDE_PATH = 'default/article.png';
    private $fileService;

    public function __construct(FileStorage $service)
    {
        $this->fileService = $service;
    }

    public function all($request)
    {
        return Recipe::filter($request)->paginate(10);
    }

    public function create(array $data, int $userId)
    {
        $pathImg = $this->fileService->saveFile('recipes', $data['preview_article']);

        $recipe = Recipe::create([
            'title' => $data['title'],
            'doctor_id' => $userId,
            'time_preparing' => $data['time_preparing'],
            'count_feed' => $data['count_feed'],
            'is_verified' => true,
            'background' => $pathImg,
            'is_create_user' => false,
        ]);

        $ingredients = collect($data['ingredients'])->map(function ($value) {
            return [
                'ingredient_id' => $value['ingredient_id'],
                'unit_id' => $value['unit'],
                'count' => $value['count'],
            ];
        });

        $recipe->ingredients()->createMany($ingredients);

        foreach ($data['steps'] as $value) {
            $urlPath = $this->fileService->saveFile('recipes', $value['preview']);

            RecipeStep::create([
                'recipe_id' => $recipe->id,
                'title' => $value['title'],
                'description' => $value['body'],
                'img_path' => $urlPath,
            ]);
        }

        $recipe->categories()->attach($data['category']);
    }

    public function delete(Recipe $recipe)
    {
        $this->fileService->deleteFileByName($recipe->background);
        $recipe->delete();
    }

    public function update(Recipe $recipe, array $data)
    {
        $recipe->update([
            'title' => $data['title'],
            'time_preparing' => $data['time_preparing'],
            'count_feed' => $data['count_feed'],
        ]);

        $recipe->categories()->sync($data['category']);

        foreach ($data['ingredients'] as $ingredient) {
            RecipeIngredient::updateOrCreate(
                [
                    'id' => $ingredient['recipe_ingredient_id'] ?? null,
                    'recipe_id' => $recipe->id,
                ],
                [
                    'ingredient_id' => $ingredient['ingredient_id'],
                    'unit_id' => $ingredient['unit'],
                    'count' => $ingredient['count'],
                ]
            );
        }

        foreach ($data['steps'] as $step) {
            RecipeStep::updateOrCreate(
                [
                    'id' => $step['step_id'] ?? null,
                    'recipe_id' => $recipe->id,
                ],
                [
                    'title' => $step['title'],
                    'description' => $step['body'],
                ]
            );
        }
    }
}
