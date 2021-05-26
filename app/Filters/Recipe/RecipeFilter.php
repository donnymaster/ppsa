<?php

namespace App\Filters\Recipe;

use App\Filters\Filter;
use App\Filters\Traits\DoctorIdTrait;

class RecipeFilter extends Filter
{
    use DoctorIdTrait;

    public function timePreparing($rangeParam = '')
    {
        $range = $this->paramToArray($rangeParam);

        return $this->builder->when($this->isNumerics($range), function ($query) use ($range) {
            return $query->whereBetween('time_preparing', $range);
        });
    }

    public function countFeed($rangeParam = '')
    {
        $range = $this->paramToArray($rangeParam);

        return $this->builder->when($this->isNumerics($range), function ($query) use ($range) {
            return $query->whereBetween('count_feed', $range);
        });
    }

    public function category($categories = '')
    {
        if ($categories && $this->isNumerics($categories)) {
            return $this->builder->whereHas('categories', function ($query) use ($categories) {
                return $query->whereIn('category_id', $categories);
            });
        }
    }
}
