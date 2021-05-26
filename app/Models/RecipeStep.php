<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * class describing the doctor model
 * @property integer $recipe_id
 * @property string $title
 * @property string $description
 * @property string $img_path
 */
class RecipeStep extends Model
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
}
