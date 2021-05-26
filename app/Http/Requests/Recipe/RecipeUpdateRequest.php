<?php

namespace App\Http\Requests\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class RecipeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'time_preparing' => 'required|numeric|min:1|max:100',
            'count_feed' => 'required|numeric|min:1|max:100',
            'steps' => 'required|array|min:1|max:10',
            'steps.*.title' => 'required',
            'steps.*.body' => 'required',
            'steps.*.step_id' => 'nullable',
            'ingredients' => 'required|array|min:1|max:20',
            'recipe_ingredient_id' => 'nullable|numeric|exists:recipe_ingredients,id',
            'ingredients.*.ingredient_id' => 'required|numeric|exists:ingredients,id',
            'ingredients.*.count' => 'required|numeric|min:1|max:1000',
            'ingredients.*.unit' => 'required|numeric|exists:units,id',
            'category' => 'required|array',
            'category.*' => 'exists:category,id'
        ];
    }
}
