<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ration_part_type_id
 * @property integer $recipe_id
 * @property integer $ration_id
 */
class RationPart extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function rationPartType()
    {
        return $this->belongsTo(RationPartType::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
