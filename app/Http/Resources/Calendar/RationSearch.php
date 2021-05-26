<?php

namespace App\Http\Resources\Calendar;

use Illuminate\Http\Resources\Json\JsonResource;

class RationSearch extends JsonResource
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
            'title' => $this->title,
            'id' => $this->id,
        ];
    }
}
