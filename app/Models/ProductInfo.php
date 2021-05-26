<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInfo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['doctor_id', 'name'];

    public function mean()
    {
        return $this->hasMany(ProductMean::class);
    }

    public function containing()
    {
        return $this->hasMany(ProductContaining::class);
    }
}
