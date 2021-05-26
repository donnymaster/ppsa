<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function filters();

    public function apply(Builder $builder);
}
