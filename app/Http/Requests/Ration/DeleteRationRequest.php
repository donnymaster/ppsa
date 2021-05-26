<?php

namespace App\Http\Requests\Ration;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ration_id' => 'required|numeric|exists:rations,id',
        ];
    }
}
