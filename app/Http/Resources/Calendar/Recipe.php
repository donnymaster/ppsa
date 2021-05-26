<?php

namespace App\Http\Resources\Calendar;

use Illuminate\Http\Resources\Json\JsonResource;

class Recipe extends JsonResource
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
            'name' => $this->recipe->title,
            'recipe_id' => $this->recipe->id,
            'ration_type_part' => new RationPartType($this->rationPartType),
        ];
    }
}
