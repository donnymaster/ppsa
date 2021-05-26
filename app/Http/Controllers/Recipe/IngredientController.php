<?php

namespace App\Http\Controllers\Recipe;

use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IngredientController extends Controller
{
    public function index(Request $request)
    {
        $ingredient = $request->get('search') ?? '';
        $ingredients = Ingredient::where('name', 'like', '%' . $ingredient . '%')->limit(30)->get();

        return response()->json(IngredientResource::collection($ingredients));
    }
}
