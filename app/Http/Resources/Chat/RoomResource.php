<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userMain = Auth::user();
        $collocutor = $this->users->where('id', '!=', $userMain->id)->first();

        return [
            'room_id' => $this->id,
            'room_name' => $this->name,
            'collocutor' => $collocutor->full_name,
            'collocutor_id' => $collocutor->id,
        ];
    }
}
