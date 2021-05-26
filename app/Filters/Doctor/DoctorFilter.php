<?php

namespace App\Filters\Doctor;

use App\Filters\Filter;

class DoctorFilter extends Filter
{
    public function experience($timeRange = '')
    {
        $range = $this->paramToArray($timeRange);

        return $this->builder->when($this->isNumerics($range), function ($query) use ($range) {
            return $query->whereBetween('work_experience', $range);
        });
    }

    public function searchByBiography($template = '')
    {
        return $this->builder->when($template, function ($query) use ($template) {
            return $query
                ->where('biography', 'like', '%' . $template . '%');
        });
    }
}
