<?php

namespace App\Traits\Filter;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait FilterTrait
{
    public function scopeFilter(Builder $builder, Filter $filter)
    {
        return $filter->apply($builder);
    }
}
