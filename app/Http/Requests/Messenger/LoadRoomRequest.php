<?php

namespace App\Http\Requests\Messenger;

use Illuminate\Foundation\Http\FormRequest;

class LoadRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'owner_id' => 'required|exists:users,id',
            'interlocutor_id' => 'required|exists:users,id',
        ];
    }
}