<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Filter implements FilterInterface
{
    public $request;
    protected $builder;
    protected $delimiter = ',';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filters()
    {
        return $this->request->query();
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            $methodName = Str::camel($name);
            if (method_exists($this, $methodName)) {
                call_user_func_array([$this, $methodName], array_filter([$value]));
            }
        }

        return $this->builder;
    }

    /**
     * @param string $param
     *
     * @return array
     */
    protected function paramToArray($param)
    {
        return explode($this->delimiter, $param);
    }

    /**
     * @param array $values
     *
     * @return bool
     */
    protected function isNumerics($values)
    {
        foreach ($values as $value) {
            if (!is_numeric($value)) {
                return false;
            }

            return true;
        }
    }
}
