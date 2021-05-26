<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * class describing the doctor model
 * @property integer $recipe_id
 * @property integer $ingredient_id
 * @property integer $unit_id
 * @property integer $count
 */
class RecipeIngredient extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
