<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDoctorRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|confirmed',
            'work_experience' => 'required|numeric|min:1|max:100',
            'biography' => 'required',
            'document' => 'nullable|array|max:5',
        ];
    }
}
