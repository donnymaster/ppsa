<?php

namespace App\Filters\Blog;

use App\Filters\Filter;
use App\Filters\Traits\DoctorIdTrait;

class BlogFilter extends Filter
{
    use DoctorIdTrait;

    /**
     * @param array|null $timeRange
     *
     * @return mixed
     */
    public function readingTime($timeRange = '')
    {
        $range = $this->paramToArray($timeRange);

        return $this->builder->when($this->isNumerics($range), function ($query) use ($range) {
            return $query->whereBetween('reading_time', $range);
        });
    }

    /**
     * @param string|null $template
     *
     * @return mixed
     */
    public function search($template = '')
    {
        return $this->builder->when($template, function ($query) use ($template) {
            return $query
                ->where('title', 'like', '%' . $template . '%')
                ->orWhere('body', 'like', '%' . $template . '%');
        });
    }
}
