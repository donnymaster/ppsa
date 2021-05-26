<?php

namespace App\Http\Controllers\Recipe;

use App\Filters\Recipe\RecipeFilter;
use App\Http\Requests\Recipe\RecipeCreateRequest;
use App\Http\Requests\Recipe\RecipeUpdateRequest;
use App\Http\Resources\Recipe\RecipeSearch as RecipeSearchResource;
use App\Models\Category;
use App\Models\CategoryRecipe;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\RecipeStep;
use App\Models\Unit;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class RecipeController extends Controller
{
    private $recipeService;

    public function __construct(RecipeService $service)
    {
        $this->recipeService = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RecipeFilter $request)
    {
        $recipes = $this->recipeService->all($request);
        $categories = Category::select('id', 'name')->get();

        return view('pages.recipe.recipes', compact(['recipes', 'categories']));
    }

    public function search(Request $request)
    {
        $search = $request->input('value') ?? '';
        $recipes = Recipe::where('title', 'like', '%' . $search . '%')->limit(30)->get();

        return response()->json(
            RecipeSearchResource::collection($recipes)
        );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::all();
        $categories = Category::all();

        return view('pages.recipe.recipes-create', compact('units', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecipeCreateRequest $request)
    {
        $user = Auth::user();

        if (!$user->isDoctor()) {
            abort(403);
        }

        $this->recipeService->create($request->validated(), $user->doctor->id);

        return redirect()->route('recipe.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = Recipe::where('id', $id)
            ->with(['steps', 'doctor', 'ingredients.unit', 'ingredients.ingredient'])
            ->firstOrFail();
        $recipeCategories = CategoryRecipe::where('recipe_id', $recipe->id)->with('category')->get();

        return view('pages.recipe.recipe-show', compact('recipe', 'recipeCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recipe = Recipe::where('id', $id)->with(['steps', 'ingredients.ingredient', 'categories'])->firstOrFail();
        $catId = $recipe->categories->pluck('id')->toArray();
        $units = Unit::all();
        $categories = Category::all();

        return view('pages.recipe.recipe-edit', compact('recipe', 'catId', 'categories', 'units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RecipeUpdateRequest $request, Recipe $recipe)
    {
        $validated = $request->validated();
        $this->recipeService->update($recipe, $validated);

        return redirect()->route('recipe.index');
    }

    public function deleteIngredient(RecipeIngredient $ingredient)
    {
        $ingredient->delete();

        return redirect()->back();
    }

    public function deleteStep(RecipeStep $step)
    {
        $recipe = $step->recipe;

        if ($recipe->steps()->count() === 1) {
            return redirect()->route('recipe.edit', ['recipe' => $recipe->id]);
        }

        $step->delete();

        return redirect()->route('recipe.edit', ['recipe' => $recipe->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        if ($recipe->rationParts()->get()->count() != 0) {
            return back()->with('error_delete', 'Не можна видалити рецепт, так як він використовується в раціоні!');
        }

        $this->recipeService->delete($recipe);

        return redirect()->route('recipe.index');
    }
}
