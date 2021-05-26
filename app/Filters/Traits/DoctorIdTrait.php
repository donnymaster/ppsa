<?php

namespace App\Filters\Traits;

trait DoctorIdTrait
{
    /**
     * @param int|null $id
     *
     * @return mixed
     */
    public function doctorId($id = '')
    {
        return $this->builder->when(is_numeric($id), function ($query) use ($id) {
            return $query->where('doctor_id', $id);
        });
    }
}
