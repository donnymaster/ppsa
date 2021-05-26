<?php

namespace App\Models;

use App\Traits\Filter\FilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory, FilterTrait;

    protected $fillable = [
        'doctor_id',
        'title',
        'time_preparing',
        'count_feed',
        'is_verified',
        'is_create_user',
        'background',
    ];

    public function steps()
    {
        return $this->hasMany(RecipeStep::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function ingredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_recipes');
    }

    public function rationParts()
    {
        return $this->hasMany(RationPart::class);
    }
}
