<?php

namespace App\Http\Resources\Calendar;

use Illuminate\Http\Resources\Json\JsonResource;

class RationPartType extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'range' => $this->range,
        ];
    }
}
