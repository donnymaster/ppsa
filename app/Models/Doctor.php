<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filter\FilterTrait;

/**
 * class describing the doctor model
 * @property integer $user_id
 * @property string $biography
 * @property string $work_experience
 * @property string $is_active
 */
class Doctor extends Model
{
    use HasFactory, FilterTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function articles()
    {
        return $this->hasMany(Blog::class);
    }

    public function materials()
    {
        return $this->hasMany(DoctorMaterial::class);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
