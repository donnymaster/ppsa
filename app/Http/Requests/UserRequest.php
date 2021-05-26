<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $validationPersonalInformation = 'required|string|max:255|min:3';

        return [
            'first_name' => $validationPersonalInformation,
            'last_name' => $validationPersonalInformation,
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:8|max:16',
            'new_password' => 'nullable|string|min:8|max:16',
        ];
    }
}
